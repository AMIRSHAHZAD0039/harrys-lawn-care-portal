<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Quote;
use App\Models\QuoteAssignment;
use App\Models\RouteSchedule;
use Carbon\Carbon;

class RouteScheduleService
{
    /**
     * Anchor Monday for Bi-Weekly parity. MUST be a Monday.
     * Set this to your real program start date.
     * Wrong value only shifts ALL bi-weekly clients to the opposite
     * week together — one-line fix, never a per-client bug.
     */
    private const PROGRAM_START = '2025-01-06'; // a Monday

    /** Higher = more frequent. Guard for the (rare) multi-seasonal quote. */
    private const PRIORITY = [
        'weekly'    => 3,
        'bi-weekly' => 2,
        'monthly'   => 1,
    ];

    /**
     * Generate route schedules for every active team for the week
     * containing $serviceDate. Idempotent — re-running the same date
     * creates nothing new.
     */
    public function generateForWeek($serviceDate = null): array
    {
        $serviceDate = $serviceDate ? Carbon::parse($serviceDate) : Carbon::now();
        $monday      = $serviceDate->copy()->startOfWeek(Carbon::MONDAY);

        $summary = [];

        $teams = Team::where('status', true)->orderBy('name')->get();

        foreach ($teams as $team) {

            $assignments = QuoteAssignment::with('quote.items')
                ->where('team_id', $team->id)
                ->where('status', 'active')
                ->get();

            $eligible = [];
            $skipped  = [];

            foreach ($assignments as $assignment) {

                $quote = $assignment->quote;
                $label = $quote->client_name ?? "Quote #" . ($quote->id ?? '?');

                if (!$quote) {
                    $skipped[] = "Assignment #{$assignment->id}: quote missing";
                    continue;
                }

                $decision = $this->isEligible($assignment, $quote, $monday);

                if ($decision['eligible']) {
                    $eligible[] = $assignment;
                } else {
                    $skipped[] = "{$label}: {$decision['reason']}";
                }
            }

            // SEAM: plug Google Route Optimization here.
            $ordered = $this->optimizeOrder($eligible);

            $created = 0;

            foreach ($ordered as $index => $assignment) {

                $exists = RouteSchedule::where('assignment_id', $assignment->id)
                    ->whereDate('service_date', $serviceDate->toDateString())
                    ->exists();

                if ($exists) {
                    continue;
                }

                RouteSchedule::create([
                    'assignment_id' => $assignment->id,
                    'service_date'  => $serviceDate->toDateString(),
                    'stop_order'    => $index + 1,
                    'route_type'    => 'optimized',
                    'status'        => 'pending',
                ]);

                $created++;
            }

            $summary[$team->name] = [
                'eligible' => count($eligible),
                'created'  => $created,
                'skipped'  => $skipped,
            ];
        }

        return $summary;
    }


    private function isEligible(QuoteAssignment $assignment, Quote $quote, Carbon $monday): array
    {
        $items = $quote->items;

        if ($items->isEmpty()) {
            return ['eligible' => false, 'reason' => 'no line items'];
        }

        $hasSeasonal = $items->contains(
            fn ($i) => strtolower(trim((string) $i->type)) === 'seasonal'
        );

        // Pure one-time: schedule exactly once, ever.
        if (!$hasSeasonal) {
            return $assignment->schedules()->exists()
                ? ['eligible' => false, 'reason' => 'one-time already scheduled']
                : ['eligible' => true,  'reason' => 'one-time first run'];
        }

        // Recurring: seasonal frequency drives the cadence.
        $cadence = $this->seasonalCadence($items);

        if (!$cadence) {
            return ['eligible' => false, 'reason' => 'seasonal item has no valid frequency'];
        }

        return $this->cadenceEligibleThisWeek($cadence, $monday);
    }


    private function seasonalCadence($items): ?string
    {
        $best      = null;
        $bestScore = 0;

        foreach ($items as $item) {

            if (strtolower(trim((string) $item->type)) !== 'seasonal') {
                continue;
            }

            $freq = $this->normalizeFrequency($item->frequency);

            if (!isset(self::PRIORITY[$freq])) {
                continue;
            }

            if (self::PRIORITY[$freq] > $bestScore) {
                $bestScore = self::PRIORITY[$freq];
                $best      = $freq;
            }
        }

        return $best;
    }


    private function normalizeFrequency(?string $freq): string
    {
        $freq = strtolower(trim((string) $freq));
        $freq = str_replace([' ', '_'], '-', $freq);

        if ($freq === 'biweekly') {
            $freq = 'bi-weekly';
        }

        return $freq;
    }


    private function cadenceEligibleThisWeek(string $cadence, Carbon $monday): array
    {
        switch ($cadence) {

            case 'weekly':
                return ['eligible' => true, 'reason' => 'weekly'];

            case 'bi-weekly':
                $anchor = Carbon::parse(self::PROGRAM_START)->startOfWeek(Carbon::MONDAY);
                $weeks  = (int) round(abs($anchor->diffInDays($monday)) / 7);

                return ($weeks % 2 === 0)
                    ? ['eligible' => true,  'reason' => 'bi-weekly on-week']
                    : ['eligible' => false, 'reason' => 'bi-weekly off-week'];

            case 'monthly':
                // first Monday of the month falls on day 1..7
                return ($monday->day <= 7)
                    ? ['eligible' => true,  'reason' => 'monthly first week']
                    : ['eligible' => false, 'reason' => 'monthly non-first week'];
        }

        return ['eligible' => false, 'reason' => 'unhandled cadence'];
    }


    /**
     * SEAM for Google Route Optimization. Preserves order for now —
     * replace the body with the optimizer call returning reordered
     * assignments.
     */
    private function optimizeOrder(array $assignments): array
    {
        return $assignments;
    }
}