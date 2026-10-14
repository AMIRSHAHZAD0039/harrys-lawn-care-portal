<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class TeamController extends Controller
{


// ----------------------showing create teams page
    public function index()
    {
        $teams = Team::latest()->get();

        return view('quotes.create-teams', compact('teams'));
    }

    
// ----------------------storing teams
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'team_lead' => 'nullable|max:255',
        'email' => 'nullable|email',
        'phone' => 'nullable|max:50',
        'password' => 'required|min:6',
    ]);

    Team::create([
        'name' => $request->name,
        'team_lead' => $request->team_lead,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'status' => 1,
    ]);

    return back()->with(
        'success',
        'Team created successfully'
    );
}


// ----------------------updating the teams
    public function update(Request $request, Team $team)
{
    $data = [
        'name' => $request->name,
        'team_lead' => $request->team_lead,
        'email' => $request->email,
        'phone' => $request->phone,
        'status' => $request->status,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $team->update($data);

    return back()->with(
        'success',
        'Team Updated Successfully'
    );
}




// ----------------------deleting the team
    public function destroy(Team $team)
    {
        $team->delete();

        return back()->with(
            'success',
            'Team Deleted Successfully'
        );
    }
}