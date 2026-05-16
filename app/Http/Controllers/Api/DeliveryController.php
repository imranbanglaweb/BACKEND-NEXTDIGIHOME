<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DeliveryController extends Controller
{
    public function download(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $purchase = ProductPurchase::with('product')
            ->where('download_token', $request->token)
            ->where('status', 'completed')
            ->first();

        if (!$purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired download token',
            ], 404);
        }

        // Check if download has expired
        if ($purchase->isDownloadExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'Download link has expired',
            ], 403);
        }

        if (!$purchase->product || !$purchase->product->file_url) {
            return response()->json([
                'success' => false,
                'message' => 'No download file available',
            ], 404);
        }

        $filePath = $purchase->product->file_url;

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found',
            ], 404);
        }

        // Track download
        $purchase->incrementDownloadCount();

        // Mark as delivered if not already
        if (!$purchase->delivered_at) {
            $purchase->update(['delivered_at' => now()]);
        }

        return Storage::disk('public')->download($filePath);
    }

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $purchase = ProductPurchase::with('product')
            ->where('download_token', $request->token)
            ->first();

        if (!$purchase) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid token',
            ]);
        }

        return response()->json([
            'valid' => true,
            'purchase' => [
                'id' => $purchase->id,
                'status' => $purchase->status,
                'product_name' => $purchase->product->name,
                'delivered' => $purchase->isDelivered(),
            ],
        ]);
    }
}