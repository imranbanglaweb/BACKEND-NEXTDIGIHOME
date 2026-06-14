<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display all customers
     */
    public function index()
    {
        $purchaseSummary = ProductPurchase::select(
                'user_id',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total) as total_spent'),
                DB::raw('MAX(created_at) as last_order_at')
            )
            ->whereNotNull('user_id')
            ->groupBy('user_id');

        $customers = User::query()
            ->leftJoinSub($purchaseSummary, 'purchase_summary', function ($join) {
                $join->on('users.id', '=', 'purchase_summary.user_id');
            })
            ->select(
                'users.*',
                DB::raw('COALESCE(purchase_summary.orders_count, 0) as orders_count'),
                DB::raw('COALESCE(purchase_summary.total_spent, 0) as total_spent'),
                'purchase_summary.last_order_at'
            )
            ->latest('users.created_at')
            ->get();

        $totalOrders = ProductPurchase::whereNotNull('user_id')->count();
        $totalRevenue = ProductPurchase::whereNotNull('user_id')->sum('total');

        $stats = [
            'total' => User::count(),
            'active' => User::where('status', '1')->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    /**
     * Show create customer form
     */
    public function create()
    {
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', '1')->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        return view('admin.customers.create', compact('stats'));
    }

    /**
     * Store a new customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'cell_phone' => 'nullable|string|max:30',
            'status' => 'required|string|in:0,1',
            'email_verified' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'user_name' => $validated['user_name'] ?: strtolower(strtok($validated['email'], '@')),
            'email' => $validated['email'],
            'cell_phone' => $validated['cell_phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'user_type' => 'customer',
            'role' => 'customer',
            'email_verified_at' => $request->boolean('email_verified') ? now() : null,
        ]);

        $user->status = $validated['status'];
        $user->save();

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display customer reviews
     */
    public function reviews()
    {
        $reviews = Testimonial::ordered()->get();
        $stats = [
            'total' => $reviews->count(),
            'active' => $reviews->where('is_active', true)->count(),
            'average' => $reviews->avg('rating') ? number_format($reviews->avg('rating'), 1) : '0.0',
            'positive' => $reviews->count() > 0 ? round(($reviews->where('rating', '>=', 4)->count() / $reviews->count()) * 100) : 0,
        ];

        return view('admin.customers.reviews', compact('reviews', 'stats'));
    }
}
