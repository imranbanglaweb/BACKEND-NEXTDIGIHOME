<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;

class StripePaymentService
{
    protected $stripe;

    public function __construct()
    {
        // Stripe is currently disabled - manual payment only
        // To enable Stripe, run: composer require stripe/stripe-php
        $this->stripe = null;
    }

    /**
     * Check if Stripe is available
     */
    public function isAvailable(): bool
    {
        return false; // Currently disabled
    }

    /**
     * Create a subscription for a company
     */
    public function createSubscription(Company $company, SubscriptionPlan $plan, array $paymentMethodData = null)
    {
        try {
            // Create or retrieve Stripe customer
            $customer = $this->getOrCreateStripeCustomer($company);

            // Create subscription data
            $subscriptionData = [
                'customer' => $customer->id,
                'items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $plan->name,
                                'description' => $plan->description ?? $plan->name . ' Plan',
                            ],
                            'unit_amount' => $plan->price * 100, // Convert to cents
                            'recurring' => [
                                'interval' => $plan->billing_cycle === 'yearly' ? 'year' : 'month',
                            ],
                        ],
                    ],
                ],
                'metadata' => [
                    'company_id' => $company->id,
                    'plan_id' => $plan->id,
                ],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
            ];

            // Add trial period if applicable
            if ($plan->trial_days > 0 && !$company->subscription) {
                $subscriptionData['trial_period_days'] = $plan->trial_days;
            }

            $stripeSubscription = $this->stripe->subscriptions->create($subscriptionData);

            // Create local subscription record
            $subscription = Subscription::create([
                'company_id' => $company->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => $stripeSubscription->id,
                'stripe_customer_id' => $customer->id,
                'status' => 'incomplete',
                'payment_status' => 'pending',
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($plan),
                'trial_ends_at' => $stripeSubscription->trial_end ? now()->createFromTimestamp($stripeSubscription->trial_end) : null,
            ]);

            return [
                'success' => true,
                'subscription' => $subscription,
                'stripe_subscription' => $stripeSubscription,
                'client_secret' => $stripeSubscription->latest_invoice->payment_intent->client_secret,
            ];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe subscription creation failed', [
                'company_id' => $company->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle Stripe webhook
     */
    public function handleWebhook(array $payload)
    {
        $event = $payload;

        switch ($event['type']) {
            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($event['data']['object']);
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event['data']['object']);
                break;

            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event['data']['object']);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event['data']['object']);
                break;
        }
    }

    /**
     * Handle successful payment
     */
    private function handlePaymentSucceeded($invoice)
    {
        $subscriptionId = $invoice['subscription'];

        $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'active',
                'payment_status' => 'paid',
                'current_period_end' => now()->createFromTimestamp($invoice['period_end']),
            ]);

            // Create payment record
            Payment::create([
                'company_id' => $subscription->company_id,
                'subscription_id' => $subscription->id,
                'plan_id' => $subscription->plan_id,
                'method' => 'stripe',
                'amount' => $invoice['amount_paid'] / 100, // Convert from cents
                'currency' => $invoice['currency'],
                'transaction_id' => $invoice['payment_intent'],
                'status' => 'paid',
                'note' => 'Recurring payment',
            ]);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailed($invoice)
    {
        $subscriptionId = $invoice['subscription'];

        $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();

        if ($subscription) {
            $subscription->update([
                'payment_status' => 'failed',
            ]);

            // Create failed payment record
            Payment::create([
                'company_id' => $subscription->company_id,
                'subscription_id' => $subscription->id,
                'plan_id' => $subscription->plan_id,
                'method' => 'stripe',
                'amount' => $invoice['amount_due'] / 100,
                'currency' => $invoice['currency'],
                'transaction_id' => $invoice['id'],
                'status' => 'failed',
                'note' => 'Payment failed - ' . ($invoice['attempt_count'] ?? 1) . ' attempts',
            ]);
        }
    }

    /**
     * Handle subscription updates
     */
    private function handleSubscriptionUpdated($stripeSubscription)
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription['id'])->first();

        if ($subscription) {
            $subscription->update([
                'status' => $stripeSubscription['status'],
                'current_period_end' => now()->createFromTimestamp($stripeSubscription['current_period_end']),
                'cancel_at_period_end' => $stripeSubscription['cancel_at_period_end'] ?? false,
            ]);
        }
    }

    /**
     * Handle subscription deletion
     */
    private function handleSubscriptionDeleted($stripeSubscription)
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription['id'])->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Subscription $subscription, bool $cancelImmediately = false)
    {
        try {
            if ($cancelImmediately) {
                $this->stripe->subscriptions->cancel($subscription->stripe_subscription_id);
            } else {
                $this->stripe->subscriptions->update($subscription->stripe_subscription_id, [
                    'cancel_at_period_end' => true,
                ]);
            }

            return ['success' => true];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update subscription plan
     */
    public function changePlan(Subscription $subscription, SubscriptionPlan $newPlan)
    {
        try {
            // Get current subscription item
            $stripeSubscription = $this->stripe->subscriptions->retrieve($subscription->stripe_subscription_id);
            $subscriptionItem = $stripeSubscription->items->data[0];

            // Update the subscription item with new price
            $this->stripe->subscriptions->update($subscription->stripe_subscription_id, [
                'items' => [
                    [
                        'id' => $subscriptionItem->id,
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $newPlan->name,
                            ],
                            'unit_amount' => $newPlan->price * 100,
                            'recurring' => [
                                'interval' => $newPlan->billing_cycle === 'yearly' ? 'year' : 'month',
                            ],
                        ],
                    ],
                ],
                'proration_behavior' => 'create_prorations',
            ]);

            // Update local subscription
            $subscription->update([
                'plan_id' => $newPlan->id,
                'end_date' => $this->calculateEndDate($newPlan),
            ]);

            return ['success' => true];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get or create Stripe customer
     */
    private function getOrCreateStripeCustomer(Company $company)
    {
        if ($company->stripe_customer_id) {
            return $this->stripe->customers->retrieve($company->stripe_customer_id);
        }

        $customer = $this->stripe->customers->create([
            'email' => $company->email,
            'name' => $company->company_name,
            'metadata' => [
                'company_id' => $company->id,
            ],
        ]);

        $company->update(['stripe_customer_id' => $customer->id]);

        return $customer;
    }

    /**
     * Calculate subscription end date
     */
    private function calculateEndDate(SubscriptionPlan $plan): \Carbon\Carbon
    {
        return $plan->billing_cycle === 'yearly'
            ? now()->addYear()
            : now()->addMonth();
    }

    /**
     * Create setup intent for saving payment methods
     */
    public function createSetupIntent(Company $company)
    {
        try {
            $customer = $this->getOrCreateStripeCustomer($company);

            $setupIntent = $this->stripe->setupIntents->create([
                'customer' => $customer->id,
                'payment_method_types' => ['card'],
            ]);

            return [
                'success' => true,
                'client_secret' => $setupIntent->client_secret,
            ];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get payment methods for a customer
     */
    public function getPaymentMethods(Company $company)
    {
        try {
            if (!$company->stripe_customer_id) {
                return ['success' => true, 'payment_methods' => []];
            }

            $paymentMethods = $this->stripe->paymentMethods->all([
                'customer' => $company->stripe_customer_id,
                'type' => 'card',
            ]);

            return [
                'success' => true,
                'payment_methods' => $paymentMethods->data,
            ];

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}