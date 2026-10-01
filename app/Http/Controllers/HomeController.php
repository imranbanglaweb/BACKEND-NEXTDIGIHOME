<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProjectInquiry;
use App\Models\Purchase;
use App\Models\User;
use App\Services\TranslationService;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->middleware('auth');
        $this->translationService = $translationService;

        // Ensure dashboard translations exist
        $this->ensureDashboardTranslations();
    }

    private function ensureDashboardTranslations()
    {
        $languages = available_languages();
        $translations = [
            'total' => 'Total',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'latest_orders' => 'Latest Orders',
            'customer' => 'Customer',
            'date' => 'Date',
            'status' => 'Status',
            'orders' => 'Orders',
            'products' => 'Products',
            'sales' => 'Sales',
            'revenue' => 'Revenue',
            'customers' => 'Customers',
            'categories' => 'Categories',
            'top_products' => 'Top Products',
            'monthly_sales' => 'Monthly Sales',
            'dashboard_overview' => 'Dashboard Overview',
            'status_progress' => 'Status Progress',
            'product_wise_sales' => 'Product-wise Sales',
            'status_ratio' => 'Status Ratio',
            'top_selling_products' => 'Top Selling Products',
            'recent_order_activity' => 'Recent Order Activity',
        ];

        foreach ($translations as $key => $default) {
            $existing = \DB::table('translations')
                ->where('group', 'backend')
                ->where('key', $key)
                ->first();
            if (! $existing) {
                foreach ($languages as $language) {
                    $this->translationService->set($key, $default, 'backend', $language->code);
                }
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user has Driver role - redirect to driver dashboard
        $isDriver = $user->hasRole('Driver');
        if (! $isDriver) {
            $userRole = $user->role ?? '';
            $isDriver = ($userRole === 'driver');
        }

        if ($isDriver) {
            return redirect()->route('driver.dashboard');
        }

        // Debug: Log user info
        \Log::info('Dashboard Access', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role_column' => $user->role,
            'user_roles' => $user->getRoleNames()->toArray(),
        ]);

        // Determine role-based query base using Spatie's hasRole method
        $isSuperAdmin = $user->hasRole('Super Admin');
        $isAdmin = $user->hasRole('Admin');
        $isSeller = $user->hasRole('Seller') || $user->hasRole('Creator');
        $isCustomer = $user->hasRole('Customer') || $user->hasRole('User');

        // Fallback to 'role' column if no Spatie role is assigned
        if (! $isSuperAdmin && ! $isAdmin && ! $isSeller && ! $isCustomer) {
            $userRole = $user->role ?? 'customer';
            $isSuperAdmin = ($userRole === 'super_admin');
            $isAdmin = ($userRole === 'admin');
            $isSeller = ($userRole === 'seller');
            $isCustomer = ($userRole === 'customer');
        }

        // Default to customer for regular users without specific roles
        if (! $isSuperAdmin && ! $isAdmin && ! $isSeller) {
            $isCustomer = true;
        }

        // Set admin flag for routing compatibility
        $isAdmin = $isSuperAdmin || $isAdmin;

        // Build queries based on role for marketplace data
        $productQuery = Product::query();
        $purchaseQuery = Purchase::query();
        $paymentQuery = Payment::query();

        if ($isSeller) {
            // Sellers see their own products and related purchases
            $products = Product::where('created_by', $user->id)->latest()->get();
            $purchases = Purchase::whereHas('product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->latest()->get();
        } elseif ($isCustomer) {
            // Customers see their purchases
            $purchases = Purchase::where('user_id', $user->id)->latest()->get();
            $products = Product::where('active', true)->latest()->take(10)->get();
        } else {
            // Admin/Super Admin sees all marketplace data
            $products = Product::latest()->get();
            $purchases = Purchase::latest()->get();
        }

        // Dashboard counters (marketplace metrics)
        if ($isSuperAdmin || $isAdmin) {
            // Admin sees all marketplace data
            $totalProducts = Product::count();
            $totalPurchases = Purchase::count();
            $totalRevenue = Payment::where('status', 'completed')->sum('amount');
            $activeProducts = Product::where('active', true)->count();
            $featuredProducts = Product::where('featured', true)->count();
            $totalCustomers = User::whereHas('roles', function ($q) {
                $q->where('name', 'Customer');
            })->count();
        } elseif ($isSeller) {
            // Sellers see their own metrics
            $totalProducts = Product::where('created_by', $user->id)->count();
            $totalPurchases = Purchase::whereHas('product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->count();
            $totalRevenue = Payment::whereHas('purchase.product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->where('status', 'completed')->sum('amount');
            $activeProducts = Product::where('created_by', $user->id)->where('active', true)->count();
            $featuredProducts = Product::where('created_by', $user->id)->where('featured', true)->count();
            $totalCustomers = 0; // Sellers don't see customer count
        } else {
            // Customers see basic marketplace info
            $totalProducts = Product::where('active', true)->count();
            $totalPurchases = Purchase::where('user_id', $user->id)->count();
            $totalRevenue = 0; // Customers don't see revenue
            $activeProducts = Product::where('active', true)->count();
            $featuredProducts = Product::where('featured', true)->count();
            $totalCustomers = 0;
        }

        // Project Inquiry stats (NextDigiHome lead generation)
        $hasInquiryTable = Schema::hasTable('project_inquiries');
        $totalInquiries = $hasInquiryTable ? ProjectInquiry::count() : 0;
        $newInquiries = $hasInquiryTable ? ProjectInquiry::where('status', 'new')->count() : 0;
        $recentInquiries = $hasInquiryTable ? ProjectInquiry::latest()->take(5)->get() : collect();

        // Overall marketplace stats
        $total = $totalProducts;
        $pending = Product::where('active', false)->count(); // Inactive products as "pending"
        $approved = $activeProducts;
        $completed = $totalPurchases;
        $rejected = Product::onlyTrashed()->count(); // Soft deleted products

        // Latest products/purchases (role-based)
        if ($isSuperAdmin || $isAdmin) {
            $latestProducts = Product::orderBy('created_at', 'desc')->take(5)->get();
            $latestPurchases = Purchase::with(['user', 'product'])->orderBy('created_at', 'desc')->take(5)->get();
        } elseif ($isSeller) {
            $latestProducts = Product::where('created_by', $user->id)->orderBy('created_at', 'desc')->take(5)->get();
            $latestPurchases = Purchase::whereHas('product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->with(['user', 'product'])->orderBy('created_at', 'desc')->take(5)->get();
        } else {
            $latestProducts = Product::where('active', true)->orderBy('created_at', 'desc')->take(5)->get();
            $latestPurchases = Purchase::where('user_id', $user->id)->with(['product'])->orderBy('created_at', 'desc')->take(5)->get();
        }

        // Monthly sales/products for last 12 months (chart 1) - role-based
        $months = collect();
        $monthLabels = [];
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $label = $dt->format('M Y');
            $monthLabels[] = $label;
            $months->push($dt->format('Y-m'));
        }

        $monthlyQuery = Product::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
            DB::raw('count(*) as total')
        )
            ->whereBetween('created_at', [Carbon::now()->subMonths(11)->startOfMonth(), Carbon::now()->endOfMonth()]);

        if ($isSeller) {
            $monthlyQuery->where('created_by', $user->id);
        }

        $monthlyCounts = $monthlyQuery->groupBy('ym')->pluck('total', 'ym')->all();

        foreach ($months as $ym) {
            $monthlyData[] = (int) ($monthlyCounts[$ym] ?? 0);
        }

        // Department breakdown (chart 2) - using categories
        $deptData = collect();
        try {
            $categoryQuery = Product::select('categories.category_name as label', DB::raw('count(*) as value'))
                ->join('categories', 'products.category', '=', 'categories.id');

            if ($isSeller && Schema::hasColumn('products', 'created_by')) {
                $categoryQuery->where('products.created_by', $user->id);
            }

            $deptData = $categoryQuery->groupBy('categories.category_name')->orderBy('value', 'desc')->limit(5)->get();
        } catch (\Exception $e) {
            $deptData = collect();
        }

        // Status counts for doughnut (chart 3)
        $statusCounts = [
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
            'completed' => $completed,
        ];

        // Top users by products (chart 4)
        $topUsers = collect();
        try {
            if (Schema::hasColumn('products', 'created_by')) {
                $topUsers = User::select('users.name as label', DB::raw('count(products.id) as value'))
                    ->join('products', 'products.created_by', '=', 'users.id')
                    ->groupBy('users.id', 'users.name')
                    ->orderBy('value', 'desc')
                    ->limit(5)
                    ->get();
            }
        } catch (\Exception $e) {
            $topUsers = collect();
        }

        // Timeline: recent product additions
        try {
            $timeline = Product::with('creator')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $timeline = Product::orderBy('created_at', 'desc')->limit(5)->get();
        }

        // Recent notifications
        $notificationsQuery = Notification::where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5);
        $notifications = $notificationsQuery->get();

        // Build payload for view
        $cards = [
            ['key' => 'new_inquiries', 'label' => 'New Leads', 'value' => $newInquiries, 'color' => '#7c3aed', 'icon' => 'fa-paper-plane'],
            ['key' => 'total_products', 'label' => 'Total Products', 'value' => $totalProducts, 'color' => '#0d6efd', 'icon' => 'fa-box'],
            ['key' => 'active_products', 'label' => 'Active Products', 'value' => $activeProducts, 'color' => '#28a745', 'icon' => 'fa-check-circle'],
            ['key' => 'total_sales', 'label' => 'Total Sales', 'value' => $totalPurchases, 'color' => '#20c997', 'icon' => 'fa-shopping-cart'],
            ['key' => 'total_revenue', 'label' => 'Total Revenue', 'value' => '$'.number_format($totalRevenue, 2), 'color' => '#ffc107', 'icon' => 'fa-dollar-sign'],
            ['key' => 'featured_products', 'label' => 'Featured Products', 'value' => $featuredProducts, 'color' => '#fd7e14', 'icon' => 'fa-star'],
            ['key' => 'total_customers', 'label' => 'Total Customers', 'value' => $totalCustomers, 'color' => '#17a2b8', 'icon' => 'fa-users'],
        ];

        // Stats array for view compatibility
        $stats = [
            'total' => $totalProducts,
            'pending' => $pending,
            'approved' => $activeProducts,
            'completed' => $totalPurchases,
            'revenue' => $totalRevenue,
            'customers' => $totalCustomers,
            'total_inquiries' => $totalInquiries,
            'new_inquiries' => $newInquiries,
        ];

        // Debug: Log stats
        \Log::info('Dashboard Stats', [
            'user_id' => $user->id,
            'total' => $total,
            'pending' => $pending,
        ]);

        // Sparkline data (dummy for last 7 days)
        $sparklineLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $sparklineData = [
            'total' => [rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100)],
            'pending' => [rand(5, 50), rand(5, 50), rand(5, 50), rand(5, 50), rand(5, 50), rand(5, 50), rand(5, 50)],
            'approved' => [rand(0, 20), rand(0, 20), rand(0, 20), rand(0, 20), rand(0, 20), rand(0, 20), rand(0, 20)],
            'rejected' => [rand(0, 10), rand(0, 10), rand(0, 10), rand(0, 10), rand(0, 10), rand(0, 10), rand(0, 10)],
            'completed' => [rand(0, 30), rand(0, 30), rand(0, 30), rand(0, 30), rand(0, 30), rand(0, 30), rand(0, 30)],
            'cancelled' => [rand(0, 5), rand(0, 5), rand(0, 5), rand(0, 5), rand(0, 5), rand(0, 5), rand(0, 5)],
        ];

        $approved = $activeProducts; // Approved products

        $payload = [
            'total' => $totalProducts,
            'pending' => $pending,
            'approved' => $approved,
            'completed' => $totalPurchases,
            'latest' => $latestPurchases ?? $latestProducts,
            'monthLabels' => $monthLabels,
            'monthlyData' => $monthlyData,
            'deptData' => $deptData,
            'statusCounts' => $statusCounts,
            'topUsers' => $topUsers,
            'timeline' => $timeline,
            'cards' => $cards,
            'stats' => $stats,
            'sparklineLabels' => $sparklineLabels,
            'sparklineData' => $sparklineData,
            'isSuperAdmin' => $isSuperAdmin,
            'isAdmin' => $isAdmin,
            'isSeller' => $isSeller,
            'isCustomer' => $isCustomer,
            'isEmployee' => false, // Not used in marketplace
            'user' => $user,
            'notifications' => $notifications,
            'totalProducts' => $totalProducts,
            'totalPurchases' => $totalPurchases,
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'totalInquiries' => $totalInquiries,
            'newInquiries' => $newInquiries,
            'recentInquiries' => $recentInquiries,
            'latestProducts' => $latestProducts ?? collect(),
            'latestPurchases' => $latestPurchases ?? collect(),
        ];

        // Route to appropriate dashboard based on role
        if ($isSuperAdmin || $isAdmin) {
            return view('admin.dashboard.admin.dashboard', $payload);
        } elseif ($isSeller) {
            return view('admin.dashboard.admin.dashboard', $payload); // Sellers also see admin dashboard for now
        } else {
            // Default to customer/marketplace dashboard
            return view('admin.dashboard.admin.dashboard', $payload);
        }
    }

    /**
     * Endpoint for live AJAX refresh (cards + latest table + charts data)
     */
    public function data(Request $request)
    {
        $user = Auth::user();

        // Determine role-based query base
        $isSuperAdmin = $user->hasRole('Super Admin');
        $isAdmin = $user->hasRole('Admin');
        $isSeller = $user->hasRole('Seller') || $user->hasRole('Creator');
        $isCustomer = $user->hasRole('Customer') || $user->hasRole('User');

        // Fallback to 'role' column if no Spatie role is assigned
        if (! $isSuperAdmin && ! $isAdmin && ! $isSeller && ! $isCustomer) {
            $userRole = $user->role ?? 'customer';
            $isSuperAdmin = ($userRole === 'super_admin');
            $isAdmin = ($userRole === 'admin');
            $isSeller = ($userRole === 'seller');
            $isCustomer = ($userRole === 'customer');
        }

        // Get marketplace data based on role
        if ($isSuperAdmin || $isAdmin) {
            $totalProducts = Product::count();
            $totalPurchases = Purchase::count();
            $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        } elseif ($isSeller) {
            $hasCreatedBy = Schema::hasColumn('products', 'created_by');
            $totalProducts = $hasCreatedBy ? Product::where('created_by', $user->id)->count() : Product::count();
            $totalPurchases = $hasCreatedBy ? Purchase::whereHas('product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->count() : 0;
            $totalRevenue = $hasCreatedBy ? Payment::whereHas('purchase.product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->where('status', 'completed')->sum('amount') : 0;
        } else {
            $totalProducts = Product::where('active', true)->count();
            $totalPurchases = Purchase::where('user_id', $user->id)->count();
            $totalRevenue = 0;
        }

        // Latest items
        if ($isSuperAdmin || $isAdmin) {
            $latest = Purchase::with(['user', 'product'])->orderBy('created_at', 'desc')->take(10)->get();
        } elseif ($isSeller && Schema::hasColumn('products', 'created_by')) {
            $latest = Purchase::whereHas('product', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })->with(['user', 'product'])->orderBy('created_at', 'desc')->take(10)->get();
        } else {
            $latest = Purchase::where('user_id', $user->id)->with(['product'])->orderBy('created_at', 'desc')->take(10)->get();
        }

        // Category breakdown
        $deptData = collect();
        try {
            $categoryQuery = Product::select('categories.category_name as label', DB::raw('count(*) as value'))
                ->join('categories', 'products.category', '=', 'categories.id');

            if ($isSeller && Schema::hasColumn('products', 'created_by')) {
                $categoryQuery->where('products.created_by', $user->id);
            }

            $deptData = $categoryQuery->groupBy('categories.category_name')->orderBy('value', 'desc')->limit(10)->get();
        } catch (\Exception $e) {
            $deptData = collect();
        }

        $hasInquiryTable = Schema::hasTable('project_inquiries');
        $totalInquiries = $hasInquiryTable ? ProjectInquiry::count() : 0;
        $newInquiries = $hasInquiryTable ? ProjectInquiry::where('status', 'new')->count() : 0;

        return response()->json([
            'total' => $totalProducts,
            'pending' => $totalPurchases,
            'completed' => $totalPurchases,
            'revenue' => $totalRevenue,
            'totalInquiries' => $totalInquiries,
            'newInquiries' => $newInquiries,
            'latest' => $latest,
            'deptData' => $deptData,
            'isAdmin' => $isSuperAdmin || $isAdmin,
            'isSeller' => $isSeller,
            'isCustomer' => $isCustomer,
        ]);
    }
}
