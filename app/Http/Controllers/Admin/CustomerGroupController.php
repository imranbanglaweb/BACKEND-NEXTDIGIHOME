<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerGroupController extends Controller
{
    /**
     * Display all customer groups
     */
    public function index()
    {
        $summary = ProductPurchase::select(
                'user_id',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total) as total_spent'),
                DB::raw('MAX(created_at) as last_order_at')
            )
            ->whereNotNull('user_id')
            ->groupBy('user_id');

        $customers = User::query()
            ->leftJoinSub($summary, 'purchase_summary', function ($join) {
                $join->on('users.id', '=', 'purchase_summary.user_id');
            })
            ->select(
                'users.id',
                'users.created_at',
                DB::raw('COALESCE(purchase_summary.orders_count, 0) as orders_count'),
                DB::raw('COALESCE(purchase_summary.total_spent, 0) as total_spent'),
                'purchase_summary.last_order_at'
            )
            ->get();

        $groups = collect([
            [
                'name' => 'VIP Customers',
                'type' => 'High Value',
                'description' => 'Customers with $1,000 or more lifetime spend.',
                'members' => $customers->where('total_spent', '>=', 1000)->count(),
                'revenue' => $customers->where('total_spent', '>=', 1000)->sum('total_spent'),
                'status' => 'Active',
            ],
            [
                'name' => 'Repeat Buyers',
                'type' => 'Retention',
                'description' => 'Customers with two or more orders.',
                'members' => $customers->where('orders_count', '>=', 2)->count(),
                'revenue' => $customers->where('orders_count', '>=', 2)->sum('total_spent'),
                'status' => 'Active',
            ],
            [
                'name' => 'New Customers',
                'type' => 'Onboarding',
                'description' => 'Customers registered during the current month.',
                'members' => $customers->filter(fn ($customer) => $customer->created_at && $customer->created_at->isSameMonth(now()))->count(),
                'revenue' => $customers->filter(fn ($customer) => $customer->created_at && $customer->created_at->isSameMonth(now()))->sum('total_spent'),
                'status' => 'Active',
            ],
            [
                'name' => 'No Purchase Yet',
                'type' => 'Activation',
                'description' => 'Customers without a completed purchase record.',
                'members' => $customers->where('orders_count', 0)->count(),
                'revenue' => 0,
                'status' => 'Active',
            ],
            [
                'name' => 'Inactive Buyers',
                'type' => 'Winback',
                'description' => 'Customers with orders but no purchase in the last 90 days.',
                'members' => $customers->filter(fn ($customer) => $customer->orders_count > 0 && $customer->last_order_at && Carbon::parse($customer->last_order_at)->diffInDays(now()) > 90)->count(),
                'revenue' => $customers->filter(fn ($customer) => $customer->orders_count > 0 && $customer->last_order_at && Carbon::parse($customer->last_order_at)->diffInDays(now()) > 90)->sum('total_spent'),
                'status' => 'Active',
            ],
        ]);

        $stats = [
            'groups' => $groups->count(),
            'grouped_customers' => $groups->sum('members'),
            'group_revenue' => $groups->sum('revenue'),
            'total_customers' => User::count(),
        ];

        return view('admin.customers.groups', compact('groups', 'stats'));
    }
}
