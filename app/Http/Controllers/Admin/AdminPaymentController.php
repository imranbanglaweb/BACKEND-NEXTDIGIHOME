<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminPaymentNotificationMail;
use App\Mail\PaymentConfirmedMail;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class AdminPaymentController extends Controller
{
    public function index()
    {
        return view('admin.payments.index');
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {

            $payments = Payment::with(['plan'])
                ->where('status', 'pending');

            return DataTables::of($payments)
                ->addIndexColumn()

                ->addColumn('company', fn ($p) => $p->company->name ?? 'N/A'
                )

                // ->addColumn('plan', function ($p) {
                //     return $p->plan
                //         ? '<span class="badge bg-primary">'.$p->plan->name.'</span>'
                //         : '<span class="badge bg-secondary">N/A</span>';
                // })
                ->addColumn('plan', function ($p) {
                    return $p->plan
                        ? '<span class="badge bg-primary btn-small">'.$p->plan->name.'</span>'
                        : '<span class="badge bg-secondary">N/A</span>';
                })
                ->addColumn('amount', fn ($p) => '<strong>'.number_format($p->amount, 2).'</strong>'
                )

                ->addColumn('method', fn () => '<span class="badge bg-warning">Manual</span>'
                )

                ->addColumn('created_at', fn ($p) => $p->created_at->format('d M Y')
                )

                ->addColumn('action', fn ($p) => '
                    <button class="btn btn-success btn-sm approveBtn" data-id="'.$p->id.'">
                        <i class="fa fa-check"></i>
                    </button>
                    <button class="btn btn-danger btn-sm rejectBtn" data-id="'.$p->id.'">
                        <i class="fa fa-times"></i>
                    </button>
                ')

                ->rawColumns(['plan', 'amount', 'method', 'action'])
                ->make(true);
        }

        return view('admin.dashboard.plans.subscriptions.payments.pending');
    }

    public function paid()
    {

        $payments = Payment::with(['company', 'plan'])
            ->where('status', 'paid')
            ->latest()
            ->paginate(20);

        return view('admin.dashboard.plans.subscriptions.payments.paid', compact('payments'));
    }

    public function paidData()
    {
        $query = Payment::with(['company', 'plan'])
            ->where('status', 'paid')
            ->select('payments.*');

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('company', fn ($p) => $p->company->name ?? 'N/A'
            )

            ->addColumn('plan', fn ($p) => '<span class="badge bg-primary">'.$p->plan->name.'</span>'
            )

            ->addColumn('amount', fn ($p) => number_format($p->amount, 2)
            )

            ->addColumn('method', fn ($p) => '<span class="badge bg-info text-dark">'.$p->method.'</span>'
            )

            ->addColumn('paid_at', fn ($p) => $p->updated_at->format('d M Y')
            )

            ->addColumn('status', fn () => '<span class="badge bg-success">Paid</span>'
            )

            ->addColumn('invoice', fn ($p) => '<a href="'.route('admin.payments.invoice', $p->id).'"
                class="btn btn-sm btn-dark">
                <i class="fa fa-file"></i> Invoice
             </a>'
            )

            ->rawColumns(['plan', 'method', 'status', 'invoice'])
            ->make(true);
    }

    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed',
            ], 422);
        }

        $payment->load(['company', 'plan']);

        // Mark payment as paid
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Activate / extend subscription
        $plan = $payment->plan;
        $duration = $plan->is_trial ? ($plan->trial_days ?? 7) : 30;

        Subscription::updateOrCreate(
            ['company_id' => $payment->company_id],
            [
                'plan_id' => $payment->plan_id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($duration),
                'status' => 'active',
            ]
        );

        // Send email to customer
        try {
            $company = $payment->company;
            if ($company && $company->email) {
                Mail::to($company->email)->send(new PaymentConfirmedMail(
                    $company,
                    $payment->plan,
                    $payment
                ));
            }

            // Send notification to admin
            $adminEmail = config('mail.mailers.smtp.username');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminPaymentNotificationMail(
                    $company,
                    $payment->plan,
                    $payment
                ));
            }
        } catch (\Exception $e) {
            \Log::error('Payment approval email error: '.$e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment approved successfully',
        ]);
    }

    public function reject(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed',
            ], 422);
        }

        $payment->update([
            'status' => 'rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment rejected successfully',
        ]);
    }

    public function byPlan()
    {
        $revenue = Payment::selectRaw('plan_id, SUM(amount) as total')
            ->where('status', 'paid')
            ->groupBy('plan_id')
            ->with('plan')
            ->get();

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        return view('admin.saas.revenue.by_plan', compact('revenue', 'totalRevenue'));
    }

    public function expiring()
    {
        $subscriptions = Subscription::with('company', 'plan')
            ->where('status', 'active')
            ->whereDate('ends_at', '<=', now()->addDays(7))
            ->orderBy('ends_at')
            ->get();

        return view('admin.dashboard.plans.subscriptions.paymentsexpiring', compact('subscriptions'));
    }
}
