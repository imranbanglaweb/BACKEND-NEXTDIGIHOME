<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index()
    {
        return $this->listPage();
    }

    private function listPage(?string $status = null, string $title = 'Order List', string $description = 'Track orders, verify payments, update fulfillment status, and export filtered data.')
    {
        $stats = [
            'total' => ProductPurchase::count(),
            'revenue' => ProductPurchase::whereIn('status', ['completed', 'delivered', 'processing'])->sum('total'),
            'pending' => ProductPurchase::where('status', 'pending')->count(),
            'shipped_today' => ProductPurchase::where('status', 'shipped')->whereDate('updated_at', today())->count(),
            'processing' => ProductPurchase::where('status', 'processing')->count(),
            'shipped' => ProductPurchase::where('status', 'shipped')->count(),
            'delivered' => ProductPurchase::where('status', 'delivered')->count(),
            'refunded' => ProductPurchase::where('status', 'refunded')->count(),
        ];

        return view('admin.orders.index', [
            'stats' => $stats,
            'pageStatus' => $status,
            'pageTitle' => $title,
            'pageDescription' => $description,
        ]);
    }

    /**
     * Get data for DataTables (AJAX)
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductPurchase::with(['product', 'user']);

            // Filter by status if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            return DataTables::of($query->latest())
                ->addIndexColumn()
                ->addColumn('order_id', fn ($p) => '#ORD-'.str_pad($p->id, 4, '0', STR_PAD_LEFT))
                ->addColumn('product_name', fn ($p) => e($p->product->name ?? 'N/A'))
                ->addColumn('customer', function ($p) {
                    $user = $p->user;
                    $name = $user ? $user->name : ($p->customer_name ?: 'Guest Customer');
                    $email = $user ? $user->email : ($p->customer_email ?: 'No email');
                    $initial = strtoupper(substr($name, 0, 1));

                    return '<div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <div class="avatar-initial rounded-circle bg-primary text-white">
                                '.e($initial).'
                            </div>
                        </div>
                        <div>
                            <div class="fw-bold">'.e($name).'</div>
                            <small class="text-muted">'.e($email).'</small>
                        </div>
                    </div>';
                })
                ->addColumn('quantity', fn ($p) => $p->quantity)
                ->addColumn('amount', fn ($p) => '<span class="fw-bold text-success">$ '.number_format($p->total, 2).'</span>')
                ->addColumn('status', function ($p) {
                    $badges = [
                        'pending' => '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>',
                        'processing' => '<span class="badge bg-primary"><i class="fas fa-cog me-1"></i>Processing</span>',
                        'shipped' => '<span class="badge bg-info"><i class="fas fa-truck me-1"></i>Shipped</span>',
                        'delivered' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Delivered</span>',
                        'completed' => '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Completed</span>',
                        'failed' => '<span class="badge bg-danger"><i class="fas fa-times me-1"></i>Failed</span>',
                        'refunded' => '<span class="badge bg-secondary"><i class="fas fa-undo me-1"></i>Refunded</span>',
                    ];

                    return $badges[$p->status] ?? '<span class="badge bg-secondary">'.e($p->status).'</span>';
                })
                ->addColumn('payment_method', function ($p) {
                    $methods = [
                        'credit_card' => '<i class="fas fa-credit-card text-primary me-1"></i>Credit Card',
                        'paypal' => '<i class="fab fa-paypal text-info me-1"></i>PayPal',
                        'stripe' => '<i class="fab fa-stripe text-purple me-1"></i>Stripe',
                        'bank_transfer' => '<i class="fas fa-university text-success me-1"></i>Bank Transfer',
                    ];

                    return $methods[$p->payment_method] ?? e(ucfirst(str_replace('_', ' ', $p->payment_method ?? 'N/A')));
                })
                ->addColumn('created_at', fn ($p) => '<span class="text-muted">'.$p->created_at->format('M d, Y H:i').'</span>')
                ->addColumn('action', function ($p) {
                    $actions = '<div class="order-action-buttons">';

                    // View button
                    $actions .= '<button class="btn btn-sm btn-outline-primary viewBtn" data-id="'.$p->id.'" title="View Details"><i class="fas fa-eye"></i></button>';

                    // Approve/Reject buttons based on status
                    if ($p->status === 'pending') {
                        $actions .= '<button class="btn btn-sm btn-outline-success approveBtn" data-id="'.$p->id.'" title="Approve Order"><i class="fas fa-check"></i></button>';
                        $actions .= '<button class="btn btn-sm btn-outline-danger rejectBtn" data-id="'.$p->id.'" title="Reject Order"><i class="fas fa-times"></i></button>';
                    }

                    $actions .= '<button class="btn btn-sm btn-outline-secondary editBtn" data-id="'.$p->id.'" title="Update Status"><i class="fas fa-edit"></i></button>';
                    $actions .= '<button type="button" class="btn btn-sm btn-outline-danger deleteBtn" data-id="'.$p->id.'" onclick="deleteOrder(event, '.$p->id.', this)" title="Delete Order"><i class="fas fa-trash"></i></button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->rawColumns(['customer', 'amount', 'status', 'payment_method', 'created_at', 'action'])
                ->make(true);
        }

        return view('admin.orders.index');
    }

    /**
     * Export filtered orders as CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = ProductPurchase::with(['product', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $fileName = 'orders-'.now()->format('Ymd-His').'.csv';

        return Response::streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order ID', 'Customer', 'Email', 'Product', 'Quantity', 'Total', 'Payment Method', 'Status', 'Created At']);

            $query->chunk(500, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        '#ORD-'.str_pad($order->id, 4, '0', STR_PAD_LEFT),
                        $order->user->name ?? $order->customer_name ?? 'Guest Customer',
                        $order->user->email ?? $order->customer_email ?? '',
                        $order->product->name ?? 'N/A',
                        $order->quantity,
                        $order->total,
                        $order->payment_method,
                        $order->status,
                        optional($order->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    /**
     * Display pending orders
     */
    public function pending()
    {
        return $this->listPage('pending', 'Pending Orders', 'Review new orders awaiting payment or fulfillment approval.');
    }

    /**
     * Display processing orders
     */
    public function processing()
    {
        return $this->listPage('processing', 'Processing Orders', 'Manage orders currently being prepared for delivery.');
    }

    /**
     * Display shipped orders
     */
    public function shipped()
    {
        return $this->listPage('shipped', 'Shipped Orders', 'Track orders that have been shipped and are awaiting delivery confirmation.');
    }

    /**
     * Display delivered orders
     */
    public function delivered()
    {
        return $this->listPage('delivered', 'Delivered Orders', 'Review completed deliveries and customer fulfillment history.');
    }

    /**
     * Display refunds
     */
    public function refunds()
    {
        return $this->listPage('refunded', 'Refunded Orders', 'Review refunded orders and payment reversal history.');
    }

    /**
     * Display order exports
     */
    public function exports()
    {
        $stats = [
            'total' => ProductPurchase::count(),
            'this_month' => ProductPurchase::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'revenue' => ProductPurchase::whereIn('status', ['completed', 'delivered', 'processing'])->sum('total'),
        ];

        return view('admin.orders.exports', compact('stats'));
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        $order = ProductPurchase::with(['product', 'user'])->findOrFail($id);

        // Return JSON for AJAX requests (from index page modal)
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'order' => $order,
            ]);
        }

        // Return view for direct access
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Approve payment and mark as completed
     */
    public function approve(Request $request, $id)
    {
        $purchase = ProductPurchase::with('product')->findOrFail($id);

        if ($purchase->status === 'pending') {
            $purchase->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Send delivery email
            \App\Jobs\SendProductDeliveryEmail::dispatch($purchase);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order approved successfully',
        ]);
    }

    /**
     * Reject/cancel order
     */
    public function reject(Request $request, $id)
    {
        $purchase = ProductPurchase::findOrFail($id);
        $purchase->update([
            'status' => 'failed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order rejected successfully',
        ]);
    }

    /**
     * Update order status
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,completed,failed,refunded',
            'notes' => 'nullable|string|max:500',
        ]);

        $purchase = ProductPurchase::findOrFail($id);
        $oldStatus = $purchase->status;

        $purchase->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Send email notifications based on status change
        if ($request->status === 'shipped' && $oldStatus !== 'shipped') {
            // Send shipping confirmation email
            \App\Jobs\SendProductDeliveryEmail::dispatch($purchase);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'new_status' => $request->status,
        ]);
    }

    /**
     * Delete an order.
     */
    public function destroy($id)
    {
        $purchase = ProductPurchase::findOrFail($id);

        $paymentProof = $purchase->payment_proof;
        $isSharedProof = $paymentProof
            ? ProductPurchase::where('payment_proof', $paymentProof)->whereKeyNot($purchase->id)->exists()
            : false;

        if ($paymentProof && ! $isSharedProof && Storage::disk('public')->exists($paymentProof)) {
            Storage::disk('public')->delete($paymentProof);
        }

        $purchase->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }
}
