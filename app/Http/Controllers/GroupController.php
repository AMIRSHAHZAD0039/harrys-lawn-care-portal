<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::query();

        if ($request->name) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $groups = $query->latest()->paginate(15)->withQueryString();

        return view('quotes.create-groups', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string',
        ]);

        Group::create($data);

        return back()->with('success', 'Group created successfully!');
    }

    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string',
        ]);

        $group->update($data);

        return back()->with('success', 'Group updated successfully!');
    }

    public function delete(Group $group)
    {
        $group->delete();

        return back()->with('success', 'Group deleted successfully!');
    }
}