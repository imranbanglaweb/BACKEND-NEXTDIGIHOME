<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display all customers
     */
    public function index()
    {
        return view('admin.customers.index');
    }

    /**
     * Show create customer form
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a new customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'customer_group' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive,suspended',
            'email_marketing' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);

        // Create user account
        $user = \App\Models\User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);

        // Create customer profile (assuming you have a Customer model or extend User)
        // For now, we'll just redirect with success
        // In a real implementation, you'd create a Customer record with all the additional fields

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Display customer reviews
     */
    public function reviews()
    {
        return view('admin.customers.reviews');
    }
}