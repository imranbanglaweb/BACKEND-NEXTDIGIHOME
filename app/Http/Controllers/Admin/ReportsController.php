<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Payment;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display the reports index page
     */
    public function index()
    {
        try {
            // Get basic statistics for the reports dashboard
            $totalSales = Payment::where('status', 'paid')->sum('amount') ?? 0;
            $totalOrders = \DB::table('product_purchases')->count() ?? 0;
            $totalCustomers = User::where('role', 'customer')->count() ?? 0; // Assuming customers have role 'customer'
            $totalProducts = Product::count() ?? 0;

            // Monthly data for charts
            $monthlySales = Payment::select(
                    DB::raw('MONTH(paid_at) as month'),
                    DB::raw('YEAR(paid_at) as year'),
                    DB::raw('SUM(amount) as total')
                )
                ->where('status', 'paid')
                ->where('paid_at', '>=', now()->startOfYear())
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get() ?? collect();

            return view('admin.reports.index', compact(
                'totalSales',
                'totalOrders',
                'totalCustomers',
                'totalProducts',
                'monthlySales'
            ));
        } catch (\Exception $e) {
            // If there's any error, return a simple test view
            return view('admin.reports.index', [
                'totalSales' => 0,
                'totalOrders' => 0,
                'totalCustomers' => 0,
                'totalProducts' => 0,
                'monthlySales' => collect(),
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display sales reports
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Sales by date
        $salesData = Payment::select(
                DB::raw('DATE(paid_at) as date'),
                DB::raw('SUM(amount) as total_sales'),
                DB::raw('COUNT(*) as transaction_count')
            )
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
        $topProducts = DB::table('product_purchases')
            ->join('products', 'product_purchases.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(product_purchases.quantity) as total_quantity'),
                DB::raw('SUM(product_purchases.total) as total_revenue')
            )
            ->where('product_purchases.status', 'delivered') // Only count completed purchases
            ->whereBetween('product_purchases.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Sales summary
        $totalSales = $salesData->sum('total_sales');
        $totalTransactions = $salesData->sum('transaction_count');
        $averageOrderValue = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        return view('admin.reports.sales', compact(
            'salesData',
            'topProducts',
            'totalSales',
            'totalTransactions',
            'averageOrderValue',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display product reports
     */
    public function products(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Product performance
        $productReports = DB::table('product_purchases')
            ->join('products', 'product_purchases.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.stock',
                DB::raw('SUM(product_purchases.quantity) as units_sold'),
                DB::raw('SUM(product_purchases.total) as total_revenue'),
                DB::raw('COUNT(DISTINCT product_purchases.user_id) as customers_count')
            )
            ->where('product_purchases.status', 'delivered')
            ->whereBetween('product_purchases.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.price', 'products.stock')
            ->orderBy('total_revenue', 'desc')
            ->paginate(15);

        // Product categories performance
        $categoryReports = DB::table('product_purchases')
            ->join('products', 'product_purchases.product_id', '=', 'products.id')
            ->select(
                DB::raw('COALESCE(products.category, "Uncategorized") as category_name'),
                DB::raw('SUM(product_purchases.quantity) as total_units'),
                DB::raw('SUM(product_purchases.total) as total_revenue'),
                DB::raw('COUNT(DISTINCT products.id) as products_count')
            )
            ->where('product_purchases.status', 'delivered')
            ->whereBetween('product_purchases.created_at', [$startDate, $endDate])
            ->groupBy('products.category')
            ->orderBy('total_revenue', 'desc')
            ->get();

        return view('admin.reports.products', compact(
            'productReports',
            'categoryReports',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display customer reports
     */
    public function customers(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Customer purchase history
        $customerReports = DB::table('product_purchases')
            ->join('users', 'product_purchases.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(product_purchases.id) as total_orders'),
                DB::raw('SUM(product_purchases.total) as total_spent'),
                DB::raw('AVG(product_purchases.total) as avg_order_value'),
                DB::raw('MAX(product_purchases.created_at) as last_order_date')
            )
            ->where('product_purchases.status', 'delivered')
            ->whereBetween('product_purchases.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->paginate(15);

        // Customer acquisition
        $customerAcquisition = DB::table('users')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as new_customers')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.customers', compact(
            'customerReports',
            'customerAcquisition',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display order reports
     */
    public function orders(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $status = $request->get('status');

        $query = \DB::table('product_purchases')
            ->join('users', 'product_purchases.user_id', '=', 'users.id')
            ->join('products', 'product_purchases.product_id', '=', 'products.id')
            ->select(
                'product_purchases.*',
                'users.name as customer_name',
                'users.email as customer_email',
                'products.name as product_name'
            )
            ->whereBetween('product_purchases.created_at', [$startDate, $endDate]);

        if ($status) {
            $query->where('product_purchases.status', $status);
        }

        $orders = $query->orderBy('product_purchases.created_at', 'desc')->paginate(15);

        // Order status breakdown
        $statusBreakdown = \DB::table('product_purchases')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get();

        // Orders by date
        $ordersByDate = \DB::table('product_purchases')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total) as total_amount')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.orders', compact(
            'orders',
            'statusBreakdown',
            'ordersByDate',
            'startDate',
            'endDate',
            'status'
        ));
    }

    /**
     * Display revenue reports
     */
    public function revenue(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $period = $request->get('period', 'monthly');

        // Revenue data based on period
        $revenueData = Payment::select(
                DB::raw($this->getDateFormat($period) . ' as period'),
                DB::raw('SUM(amount) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Revenue by payment method
        $revenueByMethod = Payment::select(
                'method',
                DB::raw('SUM(amount) as total_revenue'),
                DB::raw('COUNT(*) as transaction_count')
            )
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('method')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Subscription revenue
        $subscriptionRevenue = Payment::where('status', 'paid')
            ->whereNotNull('subscription_id')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('amount');

        // One-time purchase revenue
        $oneTimeRevenue = Payment::where('status', 'paid')
            ->whereNull('subscription_id')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('amount');

        return view('admin.reports.revenue', compact(
            'revenueData',
            'revenueByMethod',
            'subscriptionRevenue',
            'oneTimeRevenue',
            'startDate',
            'endDate',
            'period'
        ));
    }

    /**
     * Display data export page
     */
    public function export(Request $request)
    {
        $dataType = $request->get('type', 'orders');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Get sample data for preview
        $sampleData = [];
        $totalRecords = 0;

        switch ($dataType) {
            case 'orders':
                $sampleData = \DB::table('product_purchases')
                    ->join('users', 'product_purchases.user_id', '=', 'users.id')
                    ->join('products', 'product_purchases.product_id', '=', 'products.id')
                    ->select(
                        'product_purchases.*',
                        'users.name as customer_name',
                        'users.email as customer_email',
                        'products.name as product_name'
                    )
                    ->whereBetween('product_purchases.created_at', [$startDate, $endDate])
                    ->limit(5)
                    ->get();
                $totalRecords = \DB::table('product_purchases')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();
                break;
            case 'customers':
                $sampleData = User::whereBetween('created_at', [$startDate, $endDate])
                    ->limit(5)
                    ->get();
                $totalRecords = User::whereBetween('created_at', [$startDate, $endDate])->count();
                break;
            case 'products':
                $sampleData = Product::with('category')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->limit(5)
                    ->get();
                $totalRecords = Product::whereBetween('created_at', [$startDate, $endDate])->count();
                break;
            case 'payments':
                $sampleData = Payment::whereBetween('paid_at', [$startDate, $endDate])
                    ->limit(5)
                    ->get();
                $totalRecords = Payment::whereBetween('paid_at', [$startDate, $endDate])->count();
                break;
        }

        return view('admin.reports.export', compact(
            'dataType',
            'sampleData',
            'totalRecords',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Process data export
     */
    public function processExport(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:orders,customers,products,payments',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'format' => 'required|in:csv,excel,pdf',
            'include_headers' => 'boolean',
            'compress' => 'boolean',
        ]);

        $dataType = $request->data_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $format = $request->format;
        $includeHeaders = $request->boolean('include_headers', true);

        // Get data based on type
        $data = [];
        $filename = $dataType . '_export_' . date('Y-m-d_H-i-s');

        switch ($dataType) {
            case 'orders':
                $data = \DB::table('product_purchases')
                    ->join('users', 'product_purchases.user_id', '=', 'users.id')
                    ->join('products', 'product_purchases.product_id', '=', 'products.id')
                    ->select(
                        'product_purchases.id',
                        'users.name as customer_name',
                        'users.email as customer_email',
                        'products.name as product_name',
                        'product_purchases.quantity',
                        'product_purchases.price',
                        'product_purchases.total',
                        'product_purchases.status',
                        'product_purchases.created_at'
                    )
                    ->whereBetween('product_purchases.created_at', [$startDate, $endDate])
                    ->get();
                break;

            case 'customers':
                $data = User::select('id', 'name', 'email', 'created_at')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
                break;

            case 'products':
                $data = Product::select('id', 'name', 'price', 'stock', 'category', 'active', 'created_at')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
                break;

            case 'payments':
                $data = Payment::select('id', 'amount', 'method', 'status', 'paid_at', 'created_at')
                    ->whereBetween('paid_at', [$startDate, $endDate])
                    ->get();
                break;
        }

        // Generate file based on format
        if ($format === 'csv') {
            return $this->exportToCsv($data, $filename, $includeHeaders);
        } elseif ($format === 'excel') {
            return $this->exportToExcel($data, $filename, $includeHeaders);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf($data, $filename, $dataType);
        }

        return back()->with('error', 'Unsupported export format.');
    }

    /**
     * Export data to CSV
     */
    private function exportToCsv($data, $filename, $includeHeaders)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];

        $callback = function() use ($data, $includeHeaders) {
            $file = fopen('php://output', 'w');

            if ($includeHeaders && $data->count() > 0) {
                fputcsv($file, array_keys($data->first()->toArray()));
            }

            foreach ($data as $row) {
                fputcsv($file, $row->toArray());
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data to Excel (simplified CSV for now)
     */
    private function exportToExcel($data, $filename, $includeHeaders)
    {
        // For now, return CSV with Excel headers
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.xls"',
        ];

        $callback = function() use ($data, $includeHeaders) {
            $file = fopen('php://output', 'w');

            if ($includeHeaders && $data->count() > 0) {
                fputcsv($file, array_keys($data->first()->toArray()));
            }

            foreach ($data as $row) {
                fputcsv($file, $row->toArray());
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data to PDF
     */
    private function exportToPdf($data, $filename, $dataType)
    {
        // This would require a PDF library like TCPDF or DomPDF
        // For now, return a simple text response
        $content = "Export Report: " . ucfirst($dataType) . "\n\n";
        $content .= "Generated on: " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "Total records: " . $data->count() . "\n\n";

        if ($data->count() > 0) {
            $content .= implode(',', array_keys($data->first()->toArray())) . "\n";
            foreach ($data as $row) {
                $content .= implode(',', $row->toArray()) . "\n";
            }
        }

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
        ];

        return response($content, 200, $headers);
    }

    /**
     * Get date format for grouping based on period
     */
    private function getDateFormat($period)
    {
        switch ($period) {
            case 'daily':
                return 'DATE(paid_at)';
            case 'weekly':
                return 'YEARWEEK(paid_at)';
            case 'monthly':
                return 'DATE_FORMAT(paid_at, "%Y-%m")';
            case 'yearly':
                return 'YEAR(paid_at)';
            default:
                return 'DATE_FORMAT(paid_at, "%Y-%m")';
        }
    }
}