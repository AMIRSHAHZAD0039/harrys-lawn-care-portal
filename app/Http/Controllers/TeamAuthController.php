<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\RouteSchedule;
use App\Models\QuoteAssignment;
use Carbon\Carbon;

class TeamAuthController extends Controller
{
    public function showLogin()
    {
        return view('team-portal.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $team = Team::where('email',$request->email)
                    ->where('status',1)
                    ->first();

        if(!$team){
            return back()->withErrors([
                'email'=>'Invalid credentials.'
            ]);
        }

        if(!Hash::check($request->password,$team->password)){
            return back()->withErrors([
                'email'=>'Invalid credentials.'
            ]);
        }

        session([
            'team_logged_in'=>true,
            'team_id'=>$team->id,
            'team_name'=>$team->name,
        ]);

        return redirect()->route('team.dashboard');
    }

    public function logout()
    {
        session()->forget([
            'team_logged_in',
            'team_id',
            'team_name'
        ]);

        return redirect()->route('team.login');
    }



    // ===============================================================
    // TEAM PROFILE — view + edit own email / password.
    // Gated on the same session flag your login() sets.
    // ===============================================================
    public function profile()
    {
        if (!session('team_logged_in')) {
            return redirect()->route('team.login');
        }

        $team = Team::findOrFail(session('team_id'));

        return view('team-portal.team-profile', compact('team'));
    }


    public function updateProfile(Request $request)
    {
        if (!session('team_logged_in')) {
            return redirect()->route('team.login');
        }

        $team = Team::findOrFail(session('team_id'));

        // password nullable => email-only saves allowed.
        // 'confirmed' requires a matching password_confirmation field.
        $request->validate([
            'email'            => 'required|email|max:255|unique:teams,email,' . $team->id,
            'current_password' => 'required',
            'password'         => 'nullable|min:8|confirmed',
        ], [
            'current_password.required' => 'Enter your current password to save changes.',
            'password.confirmed'        => 'New password and confirmation do not match.',
            'password.min'              => 'New password must be at least 8 characters.',
            'email.unique'              => 'That email is already in use by another team.',
        ]);

        // Verify current password. Valid because login() stores a hashed
        // password (Hash::check in your login confirms this).
        if (!Hash::check($request->current_password, $team->password)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        $team->email = $request->email;

        // Overwrite password ONLY if a new one was entered.
        if ($request->filled('password')) {
            $team->password = Hash::make($request->password);
        }

        $team->save();

        // Keep session name in sync (email changed; name unchanged here,
        // but this guards against drift if you later allow name edits).
        session(['team_name' => $team->name]);

        return redirect()->route('team.profile')
            ->with('success', 'Profile updated successfully.');
    }



    // ===============================================================
    // TEAM DASHBOARD — real stats for the logged-in team only.
    // All figures derived from route_schedules + quote_assignments
    // scoped to session('team_id'). No sales/lead/revenue data
    // (none exists for a field crew in this schema).
    // ===============================================================
    public function dashboard()
    {
        if (!session('team_logged_in')) {
            return redirect()->route('team.login');
        }

        $team = Team::findOrFail(session('team_id'));

        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        // Base scope: every route_schedule belonging to THIS team.
        $teamScope = RouteSchedule::whereHas('assignment', function ($q) use ($team) {
            $q->where('team_id', $team->id);
        });

        // ---- THIS WEEK ----
        $weekBase = (clone $teamScope)
            ->whereBetween('service_date', [$weekStart->toDateString(), $weekEnd->toDateString()]);

        $weekTotal     = (clone $weekBase)->count();
        $weekCompleted = (clone $weekBase)->where('status', 'completed')->count();
        $weekPending   = (clone $weekBase)->where('status', 'pending')->count();
        $weekSkipped   = (clone $weekBase)->where('status', 'skipped')->count();

        // completion rate = completed / total * 100 (guarded)
        $weekRate = $weekTotal > 0 ? round(($weekCompleted / $weekTotal) * 100) : 0;

        // ---- ALL-TIME ----
        $allTotal     = (clone $teamScope)->count();
        $allCompleted = (clone $teamScope)->where('status', 'completed')->count();
        $allRate      = $allTotal > 0 ? round(($allCompleted / $allTotal) * 100) : 0;

        // active clients permanently assigned to this team
        $activeClients = QuoteAssignment::where('team_id', $team->id)
            ->where('status', 'active')
            ->count();

        // ---- LISTS ----
        // this week's remaining (pending) stops, in route order
        $todo = (clone $weekBase)->where('status', 'pending')
            ->with('assignment.quote')
            ->orderBy('service_date')
            ->orderBy('stop_order')
            ->get();

        // most recent completions (last 6), newest first
        $recent = (clone $teamScope)->where('status', 'completed')
            ->with('assignment.quote')
            ->orderByDesc('completed_at')
            ->limit(6)
            ->get();

        return view('team-portal.team-dashboard', compact(
            'team', 'weekStart', 'weekEnd',
            'weekTotal', 'weekCompleted', 'weekPending', 'weekSkipped', 'weekRate',
            'allTotal', 'allCompleted', 'allRate', 'activeClients',
            'todo', 'recent'
        ));
    }
}