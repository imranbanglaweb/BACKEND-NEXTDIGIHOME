<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendProductDeliveryEmail;
use App\Jobs\SendProductPurchaseEmail;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // Support both single product and cart checkout
        $validator = Validator::make($request->all(), [
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'items' => 'nullable|string', // Allow string initially, we'll parse it
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'sender_number' => 'nullable|string|max:20',
            'transaction_id' => 'nullable|string|max:100',
            'payment_method' => 'required|string|in:bkash,rocket,nagad,bank,manual,bank_transfer',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Parse items if it's a JSON string
        $items = [];
        if ($request->has('items')) {
            $itemsValue = $request->items;
            if (is_string($itemsValue)) {
                $items = json_decode($itemsValue, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid items format',
                    ], 400);
                }
            } else {
                $items = $itemsValue;
            }
        } elseif ($request->has('product_id')) {
            $items = [[
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No items provided',
            ], 400);
        }

        // Validate items array
        $itemsValidator = Validator::make(['items' => $items], [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($itemsValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Items validation failed',
                'errors' => $itemsValidator->errors(),
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $items = [];
        if ($request->has('items')) {
            $itemsValue = $request->items;
            // If items is a JSON string (from FormData), parse it
            if (is_string($itemsValue)) {
                $items = json_decode($itemsValue, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid items format',
                    ], 400);
                }
            } else {
                $items = $itemsValue;
            }
        } elseif ($request->has('product_id')) {
            $items = [[
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No items provided',
            ], 400);
        }

        DB::beginTransaction();

        try {
            $user = $request->user();
            $purchases = [];
            // Generate a shared transaction ID for the entire order
            $transactionId = 'TXN-'.Str::upper(Str::random(10));
            $downloadTokens = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                $downloadToken = Str::random(32);
                $downloadTokens[] = $downloadToken;

                // Set download expiry to 1 year from purchase for digital products
                $downloadExpiry = $product->digital ? now()->addYear() : null;

                $purchaseData = [
                    'user_id' => $user ? $user->id : null,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id ?: $transactionId,
                    'sender_number' => $request->sender_number,
                    'notes' => $request->notes,
                    'customer_email' => $request->customer_email,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'download_token' => $downloadToken,
                    'download_expires_at' => $downloadExpiry,
                    'download_count' => 0,
                ];

                // Handle payment proof upload
                if ($request->hasFile('payment_proof')) {
                    $path = $request->file('payment_proof')->store('payment_proofs', 'public');
                    $purchaseData['payment_proof'] = $path;
                }

                $purchase = ProductPurchase::create($purchaseData);

                $product->decrement('stock', $item['quantity']);
                $purchases[] = $purchase;
            }

            DB::commit();

            // Send purchase confirmation email for each purchase
            foreach ($purchases as $purchase) {
                SendProductPurchaseEmail::dispatch($purchase->load('product'));
            }

            return response()->json([
                'success' => true,
                'message' => count($purchases).' order(s) created successfully',
                'purchases' => $purchases,
                'transaction_id' => $transactionId,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: '.$e->getMessage(),
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        $purchase = ProductPurchase::where('transaction_id', $request->transaction_id)->first();

        if (! $purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        try {
            $updateData = [];

            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs', 'public');
                $updateData['payment_proof'] = $path;
            }

            // Update notes if provided
            if ($request->notes) {
                $updateData['notes'] = ($purchase->notes ? $purchase->notes.' | ' : '').$request->notes;
            }

            // Update status to payment submitted
            $updateData['status'] = 'payment_submitted';

            $purchase->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Payment verification submitted. Awaiting admin approval.',
                'purchase' => [
                    'id' => $purchase->id,
                    'status' => $purchase->status,
                    'total' => $purchase->total,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment verification: '.$e->getMessage(),
            ], 500);
        }
    }

    public function approve(Request $request, $id)
    {
        $purchase = ProductPurchase::with('product')->findOrFail($id);

        $purchase->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Send delivery email with download link
        SendProductDeliveryEmail::dispatch($purchase);

        return response()->json([
            'success' => true,
            'message' => 'Payment approved. Delivery email sent.',
            'purchase' => $purchase,
        ]);
    }

    public function myPurchases(Request $request)
    {
        $query = ProductPurchase::with(['product' => function ($q) {
            $q->select('id', 'name', 'digital', 'file_url');
        }]);

        // If user is authenticated, get by user_id or customer_email
        if ($request->user()) {
            $query->where(function ($q) use ($request) {
                $q->where('user_id', $request->user()->id)
                    ->orWhere('customer_email', $request->user()->email);
            });
        } else {
            // For guests, allow lookup by email query parameter
            $email = $request->query('email');
            if ($email) {
                $query->where('customer_email', $email);
            } else {
                return response()->json([]);
            }
        }

        $purchases = $query->orderBy('created_at', 'desc')->get();

        return response()->json($purchases);
    }
}
