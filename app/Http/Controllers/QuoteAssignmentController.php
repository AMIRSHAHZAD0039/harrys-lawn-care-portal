<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Team;
use App\Models\QuoteAssignment;
use App\Models\RouteSchedule;
use App\Services\RouteScheduleService;
use Illuminate\Support\Facades\Storage;


class QuoteAssignmentController extends Controller
{

    // ---------------------------------------------------------------
    // Assign clients to a team only. Permanent link, one per client.
    // ---------------------------------------------------------------
    public function assign(Request $request)
    {
        $quoteIds = is_array($request->quote_ids)
            ? $request->quote_ids
            : explode(',', (string) $request->quote_ids);

        foreach ($quoteIds as $quoteId) {

            $quoteId = trim($quoteId);
            if ($quoteId === '') {
                continue;
            }

            $quote = Quote::find($quoteId);
            if (!$quote) {
                continue;
            }

            $this->ensureAssignment($quote->id, $request->team_id);
        }

        return redirect('/all-quotes')
            ->with('success', 'Clients assigned successfully!');
    }


    // ---------------------------------------------------------------
    // Route generation (entry A): quote_ids comma string.
    // Manual/legacy path — appends a schedule per quote for the date.
    // ---------------------------------------------------------------
    public function optimize(Request $request)
    {
        $quoteIds = explode(',', (string) $request->quote_ids);

        foreach ($quoteIds as $index => $quoteId) {

            $quoteId = trim($quoteId);
            if ($quoteId === '') {
                continue;
            }

            $quote = Quote::find($quoteId);
            if (!$quote) {
                continue;
            }

            $assignment = $this->ensureAssignment($quote->id, $request->team_id);

            RouteSchedule::firstOrCreate(
                [
                    'assignment_id' => $assignment->id,
                    'service_date'  => $request->service_date,
                ],
                [
                    'stop_order'  => $index + 1,
                    'route_type'  => 'optimized',
                    'status'      => 'pending',
                ]
            );
        }

        return back()->with('success', 'Route generated successfully');
    }


    // ---------------------------------------------------------------
    // Route generation (entry B): optimized_stops = JSON of addresses
    // in optimized ORDER. Dashboard "Assign Route" hits this.
    // Creates the permanent assignment AND a dated route schedule.
    // Fallback: if optimized_stops is empty (form submitted before the
    // map populated it), fall back to raw quote_ids so it STILL inserts.
    // ---------------------------------------------------------------
    public function store(Request $request)
    {
        $optimizedStops = json_decode($request->optimized_stops, true);

        // ---- Fallback path: no ordered list, use quote_ids ----
        if (empty($optimizedStops)) {

            $quoteIds = array_values(array_filter(
                array_map('trim', explode(',', (string) $request->quote_ids))
            ));

            foreach ($quoteIds as $index => $quoteId) {

                $quote = Quote::find($quoteId);
                if (!$quote) {
                    continue;
                }

                $assignment = $this->ensureAssignment($quote->id, $request->team_id);

                RouteSchedule::firstOrCreate(
                    [
                        'assignment_id' => $assignment->id,
                        'service_date'  => $request->service_date,
                    ],
                    [
                        'stop_order'  => $index + 1,
                        'route_type'  => 'optimized',
                        'status'      => 'pending',
                    ]
                );
            }

            return redirect('/assigned-clients')
                ->with('success', 'Route assigned (default order — optimized list was empty).');
        }

        // ---- Normal path: ordered addresses from the map ----
        foreach ($optimizedStops as $index => $address) {

            $quote = Quote::where('client_address', trim($address))->first();
            if (!$quote) {
                continue;
            }

            $assignment = $this->ensureAssignment($quote->id, $request->team_id);

            RouteSchedule::firstOrCreate(
                [
                    'assignment_id' => $assignment->id,
                    'service_date'  => $request->service_date,
                ],
                [
                    'stop_order'  => $index + 1,
                    'route_type'  => 'optimized',
                    'status'      => 'pending',
                ]
            );
        }

        return redirect('/assigned-clients')
            ->with('success', 'Route generated & quotes assigned successfully!');
    }


    // ---------------------------------------------------------------
    // Manual trigger for "Generate This Week's Routes" button.
    // Frequency engine decides who is eligible this week.
    // ---------------------------------------------------------------
    public function generateWeeklyRoutes(Request $request, RouteScheduleService $service)
    {
        $summary = $service->generateForWeek($request->service_date);

        $created = collect($summary)->sum('created');

        return redirect('/assigned-clients')
            ->with('success', "Routes generated — {$created} stop(s) created across all teams.");
    }


    // ---------------------------------------------------------------
    // Helper: one assignment per client. Team updated to picked team;
    // assigned_at preserved on existing rows.
    // ---------------------------------------------------------------
    private function ensureAssignment($quoteId, $teamId): QuoteAssignment
    {
        $assignment = QuoteAssignment::firstOrNew(['quote_id' => $quoteId]);
        $assignment->team_id = $teamId;

        if (!$assignment->exists) {
            $assignment->assigned_at = now();
            $assignment->status      = 'active';
        }

        $assignment->save();

        return $assignment;
    }


    // ---------------------------------------------------------------
    // Assigned clients per team (permanent list + latest schedule).
    // Output shape matches the old view: assignment_id, stop_order,
    // service_date, route_type + quote fields.
    // ---------------------------------------------------------------
   public function assignedClients()
{
    $teams = Team::where('status', true)->orderBy('name')->get();

    foreach ($teams as $team) {

        $team->clients = QuoteAssignment::with(['quote.items', 'latestSchedule'])
            ->where('team_id', $team->id)
            ->where('status', 'active')
            ->get()
            ->map(function ($assignment) {

                $row = $assignment->quote;
                if (!$row) {
                    return null;
                }

                $schedule = $assignment->latestSchedule;

                $row->assignment_id = $assignment->id;
                $row->stop_order    = $schedule?->stop_order;
                $row->service_date  = $schedule?->service_date;
                $row->route_type    = $schedule?->route_type;

                // Derive Service Type + Frequency from quote_items
                $seasonal = $row->items->first(
                    fn ($i) => strtolower(trim((string) $i->type)) === 'seasonal'
                );

                if ($seasonal) {
                    $row->service_type       = 'Seasonal';
                    $row->seasonal_frequency = $seasonal->frequency ?: '—';
                } else {
                    $row->service_type       = 'One-Time';
                    $row->seasonal_frequency = '—';
                }

                return $row;
            })
            ->filter()
            ->values();
    }

    return view('quotes.assigned-clients', compact('teams'));
}


    // ---------------------------------------------------------------
    // Move client to a different team (and optionally edit latest date).
    // ---------------------------------------------------------------
    public function updateAssignment(Request $request, $id)
    {
        $assignment = QuoteAssignment::findOrFail($id);

        $assignment->update(['team_id' => $request->team_id]);

        if ($request->filled('service_date')) {

            $latest = $assignment->schedules()->latest('service_date')->first();

            if ($latest) {
                $latest->update(['service_date' => $request->service_date]);
            }
        }

        return redirect('/assigned-clients')
            ->with('success', 'Assignment updated successfully!');
    }


    // ---------------------------------------------------------------
    // Delete the assignment entirely (cascade removes all schedules).
    // ---------------------------------------------------------------
    public function destroyAssignment($id)
    {
        QuoteAssignment::findOrFail($id)->delete();

        return redirect('/assigned-clients')
            ->with('success', 'Assignment removed successfully!');
    }


    // ---------------------------------------------------------------
    // Delete a single route stop without touching the assignment.
    // ---------------------------------------------------------------
    public function destroySchedule($id)
    {
        RouteSchedule::findOrFail($id)->delete();

        return back()->with('success', 'Route stop removed successfully!');
    }




    // ------------------------------------------------------------------------------
    // Weekly route board: every team's stops for the week containing
    // the given date (defaults to today's week). Reads route_schedules.
    // ---------------------------------------------------------------
    public function weeklyRoutes(Request $request)
    {
        $date   = $request->date ? \Carbon\Carbon::parse($request->date) : \Carbon\Carbon::now();
        $start  = $date->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        $end    = $date->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $teams = Team::where('status', true)->orderBy('name')->get();

        foreach ($teams as $team) {

            $team->stops = RouteSchedule::with('assignment.quote')
                ->whereHas('assignment', function ($q) use ($team) {
                    $q->where('team_id', $team->id);
                })
                ->whereBetween('service_date', [$start->toDateString(), $end->toDateString()])
                ->orderBy('service_date')
                ->orderBy('stop_order')
                ->get();

            // quick counts for the header
            $team->total_stops = $team->stops->count();
            $team->done_stops  = $team->stops->where('status', 'completed')->count();
        }

        return view('quotes.weekly-routes', [
            'teams'     => $teams,
            'weekStart' => $start,
            'weekEnd'   => $end,
            'dateInput' => $date->toDateString(),
        ]);
    }


    // ---------------------------------------------------------------
    // Flip a single stop's status (pending <-> completed) or skip.
    // ---------------------------------------------------------------
    public function updateScheduleStatus(Request $request, $id)
    {
        $schedule = RouteSchedule::findOrFail($id);

        $status = $request->status; // pending | completed | skipped

        if (!in_array($status, ['pending', 'completed', 'skipped'])) {
            $status = 'pending';
        }

        $schedule->update(['status' => $status]);

        return back()->with('success', 'Stop marked ' . $status . '.');
    }






    // ---------------------------------------------------------------
    // JOB HISTORY: flat log of every route stop ever created.
    // Filters: status, team, date range. Paginated.
    // ---------------------------------------------------------------
    public function jobHistory(Request $request)
    {
        $query = RouteSchedule::with(['assignment.quote', 'assignment.team'])
            ->orderBy('service_date', 'desc')
            ->orderBy('stop_order');

        // filter: status
        if ($request->filled('status') && in_array($request->status, ['pending', 'completed', 'skipped'])) {
            $query->where('status', $request->status);
        }

        // filter: team
        if ($request->filled('team_id')) {
            $teamId = $request->team_id;
            $query->whereHas('assignment', function ($q) use ($teamId) {
                $q->where('team_id', $teamId);
            });
        }

        // filter: date range
        if ($request->filled('from')) {
            $query->whereDate('service_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('service_date', '<=', $request->to);
        }

        $schedules = $query->paginate(25)->withQueryString();

        $teams = Team::orderBy('name')->get();

        // summary counts across the WHOLE table (not just this page)
        $counts = [
            'total'     => RouteSchedule::count(),
            'completed' => RouteSchedule::where('status', 'completed')->count(),
            'pending'   => RouteSchedule::where('status', 'pending')->count(),
            'skipped'   => RouteSchedule::where('status', 'skipped')->count(),
        ];

        return view('quotes.job-history', compact('schedules', 'teams', 'counts'));
    }


    // ---------------------------------------------------------------
    // CLIENT HISTORY: full visit timeline for one assignment (client).
    // ---------------------------------------------------------------
    public function clientHistory($assignmentId)
    {
        $assignment = QuoteAssignment::with(['quote', 'team'])->findOrFail($assignmentId);

        $schedules = RouteSchedule::where('assignment_id', $assignmentId)
            ->orderBy('service_date', 'desc')
            ->get();

        $counts = [
            'total'     => $schedules->count(),
            'completed' => $schedules->where('status', 'completed')->count(),
            'pending'   => $schedules->where('status', 'pending')->count(),
            'skipped'   => $schedules->where('status', 'skipped')->count(),
        ];

        return view('quotes.client-history', compact('assignment', 'schedules', 'counts'));
    }
    // ========================================================================team portal

   // ===============================================================
    // TEAM PORTAL — /assigned-jobs
    // Logged-in team sees THIS WEEK's stops, marks each complete with
    // a camera photo + SERVER timestamp.

    public function teamPortal(Request $request, $teamId = null)
    {
        $resolvedTeamId = session('team_id') ?? $teamId;

        if (!$resolvedTeamId) {
            abort(403, 'No team session found. Log in as a team.');
        }

        $team = Team::findOrFail($resolvedTeamId);

        $date  = $request->date ? \Carbon\Carbon::parse($request->date) : \Carbon\Carbon::now();
        $start = $date->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        $end   = $date->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $stops = RouteSchedule::with('assignment.quote')
            ->whereHas('assignment', function ($q) use ($team) {
                $q->where('team_id', $team->id);
            })
            ->whereBetween('service_date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('service_date')
            ->orderBy('stop_order')
            ->get();

        $done  = $stops->where('status', 'completed')->count();
        $total = $stops->count();
         $pending = $stops->where('status', 'pending')->count();   // ADD
        $skipped = $stops->where('status', 'skipped')->count();   // ADD

        return view('team-portal.assigned-jobs', [
            'team'      => $team,
            'stops'     => $stops,
            'weekStart' => $start,
            'weekEnd'   => $end,
            'done'      => $done,
            'total'     => $total,
             'pending'   => $pending,   // ADD
            'skipped'   => $skipped,   // ADD
            'dateInput' => $date->toDateString(),
        ]);
    }


   /**
     * All proof timestamps are stamped in Vancouver local time.
     * IANA identifier handles the PST/PDT switch automatically —
     * NEVER hardcode -7 or -8, it is wrong half the year.
     */
    private const PROOF_TZ = 'America/Vancouver';


    // Start a job: append a BEFORE photo + its own GPS. Repeatable — each call adds one.
    public function startJob(Request $request, $id)
    {
        $request->validate([
            'before_photo'    => 'required|file|mimes:jpeg,jpg,png,webp,heic,heif|max:10240',
            'before_lat'      => 'required|numeric|between:-90,90',
            'before_lng'      => 'required|numeric|between:-180,180',
            'before_accuracy' => 'nullable|numeric|min:0',
        ], [
            'before_photo.required' => 'A before photo is required to start this job.',
            'before_photo.mimes'    => 'Photo must be JPEG, PNG, JPG, WEBP, or HEIC.',
            'before_photo.max'      => 'Photo must be under 10 MB.',
            'before_lat.required'   => 'Location access is required. Enable GPS and retry.',
            'before_lng.required'   => 'Location access is required. Enable GPS and retry.',
        ]);

        $schedule = RouteSchedule::findOrFail($id);

        // Don't add photos to a finished or skipped job.
        if (in_array($schedule->status, ['completed', 'skipped'], true)) {
            return back()->withErrors(['before_photo' => 'This job is '.$schedule->status.'. Undo it before adding photos.']);
        }

        $path = $request->file('before_photo')->store('proofs', 'public');

        // $casts => 'array' makes before_photo an array. Pull, append, reassign.
        $photos   = $schedule->before_photo ?? [];
        $photos[] = [
            'path'     => $path,
            'lat'      => (float) $request->before_lat,
            'lng'      => (float) $request->before_lng,
            'accuracy' => $request->filled('before_accuracy') ? (float) $request->before_accuracy : null,
            'taken_at' => \Carbon\Carbon::now(self::PROOF_TZ)->toDateTimeString(),
        ];
        $schedule->before_photo = $photos;

        // First before photo stamps the start time; later ones don't re-stamp.
        if (!$schedule->started_at) {
            $schedule->started_at = \Carbon\Carbon::now(self::PROOF_TZ);
        }

        $schedule->save();

        return back()->with('success', 'Before photo + location saved ('.count($photos).' total).');
    }


    // Complete a job: append an AFTER photo + its own GPS, then mark completed.
    // Requires at least one before photo first.
   // Add ONE after photo + its own GPS. Repeatable — does NOT complete the job.
    // Job stays "in progress" (before exists, not yet marked complete).
    public function addAfterPhoto(Request $request, $id)
    {
        $request->validate([
            'proof_photo'    => 'required|file|mimes:jpeg,jpg,png,webp,heic,heif|max:10240',
            'after_lat'      => 'required|numeric|between:-90,90',
            'after_lng'      => 'required|numeric|between:-180,180',
            'after_accuracy' => 'nullable|numeric|min:0',
        ], [
            'proof_photo.required' => 'An after photo is required.',
            'proof_photo.mimes'    => 'Photo must be JPEG, PNG, JPG, WEBP, or HEIC.',
            'proof_photo.max'      => 'Photo must be under 10 MB.',
            'after_lat.required'   => 'Location access is required. Enable GPS and retry.',
            'after_lng.required'   => 'Location access is required. Enable GPS and retry.',
        ]);

        $schedule = RouteSchedule::findOrFail($id);

        if ($schedule->status === 'completed') {
            return back()->withErrors(['proof_photo' => 'Job is already completed. Undo it to add more photos.']);
        }
        if ($schedule->status === 'skipped') {
            return back()->withErrors(['proof_photo' => 'Job is skipped. Undo it first.']);
        }

        // Enforce before-then-after order.
        if (empty($schedule->before_photo)) {
            return back()->withErrors(['proof_photo' => 'Add at least one before photo first.']);
        }

        $path = $request->file('proof_photo')->store('proofs', 'public');

        $photos   = $schedule->proof_photo ?? [];
        $photos[] = [
            'path'     => $path,
            'lat'      => (float) $request->after_lat,
            'lng'      => (float) $request->after_lng,
            'accuracy' => $request->filled('after_accuracy') ? (float) $request->after_accuracy : null,
            'taken_at' => \Carbon\Carbon::now(self::PROOF_TZ)->toDateTimeString(),
        ];
        $schedule->proof_photo = $photos;
        $schedule->save();

        return back()->with('success', 'After photo added ('.count($photos).' total).');
    }


    // Mark the job complete — EXPLICIT button, no photo upload.
    // Requires at least one before AND one after photo already present.
    public function completeJob($id)
    {
        $schedule = RouteSchedule::findOrFail($id);

        if (empty($schedule->before_photo)) {
            return back()->withErrors(['complete' => 'Add at least one before photo before completing.']);
        }
        if (empty($schedule->proof_photo)) {
            return back()->withErrors(['complete' => 'Add at least one after photo before completing.']);
        }

        $schedule->update([
            'status'       => 'completed',
            'completed_at' => \Carbon\Carbon::now(self::PROOF_TZ),
        ]);

        return back()->with('success', 'Job completed.');
    }


    // Delete ONE photo (by its stored path) from either array + remove its file from disk.
    // This is the method the "Remove" buttons in the Blade call — it did not exist before.
    public function deletePhoto(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:before,after',
            'path' => 'required|string',
        ]);

        $schedule = RouteSchedule::findOrFail($id);

        // Don't allow editing photos on a completed job — undo it first.
        if ($schedule->status === 'completed') {
            return back()->withErrors(['photo' => 'Job is completed. Undo it before editing photos.']);
        }

        $column = $request->type === 'before' ? 'before_photo' : 'proof_photo';
        $photos = $schedule->$column ?? [];

        $kept    = [];
        $removed = false;
        foreach ($photos as $p) {
            if (!$removed && ($p['path'] ?? null) === $request->path) {
                if (!empty($p['path']) && Storage::disk('public')->exists($p['path'])) {
                    Storage::disk('public')->delete($p['path']);
                }
                $removed = true;
                continue; // skip this one (deleted)
            }
            $kept[] = $p;
        }

        $schedule->$column = $kept;

        // If the last before photo was removed, un-stamp the start time.
        if ($column === 'before_photo' && count($kept) === 0) {
            $schedule->started_at = null;
        }

        $schedule->save();

        return back()->with('success', $removed ? 'Photo removed.' : 'Photo not found.');
    }


    // Reset a stop fully to pending: delete ALL before + after files, clear both arrays.
    public function undoJob($id)
    {
        $schedule = RouteSchedule::findOrFail($id);

        // delete every after photo file
        foreach (($schedule->proof_photo ?? []) as $p) {
            if (!empty($p['path']) && Storage::disk('public')->exists($p['path'])) {
                Storage::disk('public')->delete($p['path']);
            }
        }

        // delete every before photo file
        foreach (($schedule->before_photo ?? []) as $p) {
            if (!empty($p['path']) && Storage::disk('public')->exists($p['path'])) {
                Storage::disk('public')->delete($p['path']);
            }
        }

        $schedule->update([
            'status'          => 'pending',
            'completed_at'    => null,
            'proof_photo'     => null,
            'started_at'      => null,
            'before_photo'    => null,
            'before_lat'      => null,
            'before_lng'      => null,
            'before_accuracy' => null,
            'after_lat'       => null,
            'after_lng'       => null,
            'after_accuracy'  => null,
        ]);

        return back()->with('success', 'Job reset to pending — all photos removed.');
    }



    // ===============================================================
    // TEAM HISTORY — /team-history
    // Every route stop this LOGGED-IN team has ever had, all weeks,
    // with status. Optional ?status= filter. Same auth model as the
    // portal: team resolved from session (test param = localhost only).
    // ===============================================================
    public function teamHistory(Request $request, $teamId = null)
    {
        $resolvedTeamId = session('team_id') ?? $teamId;

        if (!$resolvedTeamId) {
            abort(403, 'No team session found. Log in as a team.');
        }

        $team = Team::findOrFail($resolvedTeamId);

        $query = RouteSchedule::with('assignment.quote')
            ->whereHas('assignment', function ($q) use ($team) {
                $q->where('team_id', $team->id);
            })
            ->orderBy('service_date', 'desc')
            ->orderBy('stop_order');

        // optional status filter
        if ($request->filled('status') && in_array($request->status, ['pending', 'completed', 'skipped'])) {
            $query->where('status', $request->status);
        }

        $schedules = $query->paginate(20)->withQueryString();

        // counts across this team's WHOLE history (not just current page)
        $base = RouteSchedule::whereHas('assignment', function ($q) use ($team) {
            $q->where('team_id', $team->id);
        });

        $counts = [
            'total'     => (clone $base)->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'pending'   => (clone $base)->where('status', 'pending')->count(),
            'skipped'   => (clone $base)->where('status', 'skipped')->count(),
        ];

        return view('team-portal.team-history', compact('team', 'schedules', 'counts'));
    }

}