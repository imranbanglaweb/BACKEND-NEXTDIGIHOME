<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index()
    {
        return view('admin.orders.index');
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

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('order_id', fn ($p) => '#ORD-'.str_pad($p->id, 4, '0', STR_PAD_LEFT))
                ->addColumn('product_name', fn ($p) => $p->product->name ?? 'N/A')
                ->addColumn('customer', function ($p) {
                    $user = $p->user;
                    $name = $user ? $user->name : $p->customer_name;
                    $email = $user ? $user->email : $p->customer_email;

                    return '<div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <div class="avatar-initial rounded-circle bg-primary text-white">
                                '.substr($name, 0, 1).'
                            </div>
                        </div>
                        <div>
                            <div class="fw-bold">'.$name.'</div>
                            <small class="text-muted">'.$email.'</small>
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

                    return $badges[$p->status] ?? '<span class="badge bg-secondary">'.$p->status.'</span>';
                })
                ->addColumn('payment_method', function ($p) {
                    $methods = [
                        'credit_card' => '<i class="fas fa-credit-card text-primary me-1"></i>Credit Card',
                        'paypal' => '<i class="fab fa-paypal text-info me-1"></i>PayPal',
                        'stripe' => '<i class="fab fa-stripe text-purple me-1"></i>Stripe',
                        'bank_transfer' => '<i class="fas fa-university text-success me-1"></i>Bank Transfer',
                    ];

                    return $methods[$p->payment_method] ?? ucfirst(str_replace('_', ' ', $p->payment_method));
                })
                ->addColumn('created_at', fn ($p) => '<span class="text-muted">'.$p->created_at->format('M d, Y H:i').'</span>')
                ->addColumn('action', function ($p) {
                    $actions = '';

                    // View button
                    $actions .= '<button class="btn btn-sm btn-outline-primary me-1 viewBtn" data-id="'.$p->id.'" title="View Details"><i class="fas fa-eye"></i></button>';

                    // Approve/Reject buttons based on status
                    if ($p->status === 'pending') {
                        $actions .= '<button class="btn btn-sm btn-outline-success me-1 approveBtn" data-id="'.$p->id.'" title="Approve Order"><i class="fas fa-check"></i></button>';
                        $actions .= '<button class="btn btn-sm btn-outline-danger me-1 rejectBtn" data-id="'.$p->id.'" title="Reject Order"><i class="fas fa-times"></i></button>';
                    }

                    // Edit button for processing/shipped orders
                    if (in_array($p->status, ['processing', 'shipped'])) {
                        $actions .= '<button class="btn btn-sm btn-outline-warning me-1 editBtn" data-id="'.$p->id.'" title="Update Status"><i class="fas fa-edit"></i></button>';
                    }

                    return $actions;
                })
                ->rawColumns(['customer', 'amount', 'status', 'payment_method', 'created_at', 'action'])
                ->make(true);
        }

        return view('admin.orders.index');
    }

    /**
     * Display pending orders
     */
    public function pending()
    {
        return view('admin.orders.pending');
    }

    /**
     * Display processing orders
     */
    public function processing()
    {
        return view('admin.orders.processing');
    }

    /**
     * Display shipped orders
     */
    public function shipped()
    {
        return view('admin.orders.shipped');
    }

    /**
     * Display delivered orders
     */
    public function delivered()
    {
        return view('admin.orders.delivered');
    }

    /**
     * Display refunds
     */
    public function refunds()
    {
        return view('admin.orders.refunds');
    }

    /**
     * Display order exports
     */
    public function exports()
    {
        return view('admin.orders.exports');
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
}
