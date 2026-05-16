<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ManualPaymentController extends Controller
{
    /**
     * Show manual payment form
     */
    public function form($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        
        $currentSubscription = null;
        if (auth()->check() && auth()->user()->company_id) {
            $currentSubscription = \App\Models\Subscription::with('plan')
                ->where('company_id', auth()->user()->company_id)
                ->where('status', 'active')
                ->first();
        }
        
        return view('admin.dashboard.plans.manual', compact('plan', 'currentSubscription'));
    }

    /**
     * Store manual payment request (AJAX)
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'trx_id'  => 'required|string',
            'amount'  => 'nullable|numeric|min:0',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $amount = $request->amount ?? $plan->price;
        
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to continue.',
                'redirect' => route('login'),
            ], 401);
        }
        
        $user = auth()->user();

        if (!$user->company_id) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is not associated with a company. Please contact an administrator.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            /**
             * 1️⃣ Create PENDING subscription
             */
            $subscription = Subscription::create([
                'company_id'      => $user->company_id,
                'user_id'         => auth()->id(),
                'plan_id'         => $plan->id,
                'starts_at'       => null,
                'ends_at'         => null,
                'status'          => 'pending',
                'payment_method'  => 'manual',
                'transaction_ref' => $request->trx_id,
            ]);

            /**
             * 2️⃣ Create PENDING payment
             */
            $payment = Payment::create([
                'company_id'      => $user->company_id,
                'user_id'         => auth()->id(),
                'subscription_id' => $subscription->id,
                'plan_id'         => $plan->id,
                'method'          => 'manual',
                'amount'          => $amount,
                'currency'        => 'BDT',
                'transaction_id'  => $request->trx_id,
                'status'          => 'pending',
                'created_by'      => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'Manual payment request submitted successfully',
                'invoice_url' => route('invoice.download', $payment->id),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error'   => $e->getMessage(), // remove in production
            ], 500);
        }
    }

    /**
     * Store manual payment request (non-AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'trx_id'  => 'required|string',
            'amount'  => 'required|numeric|min:1',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Validate that user has a company_id
        if (!$user->company_id) {
            return redirect()->back()->with('error', 'Your account is not associated with a company. Please contact an administrator.');
        }

        DB::beginTransaction();

        try {
            /**
             * 1️⃣ Create PENDING subscription
             */
            $subscription = Subscription::create([
                'company_id'      => $user->company_id,
                'user_id'         => auth()->id(),
                'plan_id'         => $plan->id,
                'starts_at'       => null,
                'ends_at'         => null,
                'status'          => 'pending',
                'payment_method'  => 'manual',
                'transaction_ref' => $request->trx_id,
            ]);

            /**
             * 2️⃣ Create PENDING payment
             */
            $payment = Payment::create([
                'company_id'      => $user->company_id,
                'user_id'         => auth()->id(),
                'subscription_id' => $subscription->id,
                'plan_id'         => $plan->id,
                'method'          => 'manual',
                'amount'          => $request->amount,
                'currency'        => 'BDT',
                'transaction_id'  => $request->trx_id,
                'status'          => 'pending',
                'created_by'      => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('invoice.download', $payment->id)->with('success', 'Manual payment request submitted successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Manual payment store error', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Something went wrong. Please try again: ' . $e->getMessage());
        }
    }

    /**
     * Download invoice
     */
    public function invoice(Payment $payment)
    {
        $payment->load([
            'subscription.plan',
            'company',
            'user',
        ]);

        $pdf = PDF::loadView(
            'admin.dashboard.plans.subscriptions.payments.invoice.pdf',
            compact('payment')
        )->setPaper('A4');

        return $pdf->download('invoice-'.$payment->id.'.pdf');
    }
}
