<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    protected $stripeService;

    public function __construct(StripePaymentService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Handle Stripe webhooks
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $eventType = $payload['type'] ?? null;

        Log::info('Stripe webhook received', [
            'type' => $eventType,
            'id' => $payload['id'] ?? null,
        ]);

        try {
            $this->stripeService->handleWebhook($payload);

            return response()->json(['status' => 'success'], Response::HTTP_OK);

        } catch (\Exception $e) {
            Log::error('Stripe webhook processing failed', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return response()->json(['status' => 'error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}