<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index()
    {
        $team = TeamMember::active()->ordered()->get();
        return response()->json([
            'success' => true,
            'data' => $team,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team', 'public');
            $data['image'] = $imagePath;
        }

        $member = TeamMember::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Team member created successfully',
            'data' => $member,
        ], 201);
    }

    public function show(TeamMember $teamMember)
    {
        return response()->json([
            'success' => true,
            'data' => $teamMember,
        ]);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($teamMember->image && Storage::disk('public')->exists($teamMember->image)) {
                Storage::disk('public')->delete($teamMember->image);
            }

            $imagePath = $request->file('image')->store('team', 'public');
            $data['image'] = $imagePath;
        }

        $teamMember->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Team member updated successfully',
            'data' => $teamMember,
        ]);
    }

    public function destroy(TeamMember $teamMember)
    {
        // Delete image if exists
        if ($teamMember->image && Storage::disk('public')->exists($teamMember->image)) {
            Storage::disk('public')->delete($teamMember->image);
        }

        $teamMember->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team member deleted successfully',
        ]);
    }
}