<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $itemId => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $cartItems[] = [
                    'id' => $itemId,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                    'thumbnail' => $product->thumbnail,
                ];
                $total += $itemTotal;
            }
        }

        return response()->json([
            'items' => $cartItems,
            'count' => count($cartItems),
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $request->session()->get('cart', []);
        $itemId = 'item_' . time();

        $cart[$itemId] = [
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ];

        $request->session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
        ]);
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found',
        ], 404);
    }

    public function destroy(Request $request, $itemId)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            $request->session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found',
        ], 404);
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}