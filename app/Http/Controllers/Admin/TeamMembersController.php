<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teamMembers = TeamMember::orderBy('sort_order')->paginate(15);

        return view('admin.team-members.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team-members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/team-members'), $imageName);
            $data['image'] = 'images/team-members/' . $imageName;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamMember $teamMember)
    {
        return view('admin.team-members.show', compact('teamMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamMember $teamMember)
    {
        return view('admin.team-members.edit', compact('teamMember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($teamMember->image && file_exists(public_path($teamMember->image))) {
                unlink(public_path($teamMember->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/team-members'), $imageName);
            $data['image'] = 'images/team-members/' . $imageName;
        }

        $teamMember->update($data);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $teamMember)
    {
        // Delete image file
        if ($teamMember->image && file_exists(public_path($teamMember->image))) {
            unlink(public_path($teamMember->image));
        }

        $teamMember->delete();

        return redirect()->route('admin.team-members.index')->with('success', 'Team member deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(TeamMember $teamMember)
    {
        $teamMember->update(['is_active' => !$teamMember->is_active]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}