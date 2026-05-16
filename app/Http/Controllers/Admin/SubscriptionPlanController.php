<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    /**
     * Display all subscription plans
     */
    public function index()
    {
        return view('admin.subscriptions.plans');
    }

    /**
     * Show create plan form
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a new plan
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:days,weeks,months,years',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Here you would create the subscription plan
        // For now, just redirect with success
        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        return view('admin.subscriptions.edit', compact('id'));
    }

    /**
     * Update plan
     */
    public function update(Request $request, $id)
    {
        // Update logic here
        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan updated successfully!');
    }

    /**
     * Delete plan
     */
    public function destroy($id)
    {
        // Delete logic here
        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan deleted successfully!');
    }
}