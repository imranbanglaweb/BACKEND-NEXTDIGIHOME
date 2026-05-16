<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('active', true)
            ->when(request('featured'), function($query) {
                return $query->where('featured', true);
            })
            ->when(request('category'), function($query) {
                return $query->where('category', request('category'));
            })
            ->when(request('search'), function($query) {
                $search = request('search');
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy(request('sort_by', 'created_at'), request('sort_order', 'desc'))
            ->paginate(request('per_page', 12))
            ->withQueryString();

        return response()->json($products);
    }

    /**
     * Get all product categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $categories = \App\Models\Category::select('id', 'category_name', 'category_slug as slug')
            ->where('status', 1)
            ->orderBy('category_name')
            ->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'digital' => 'required|boolean',
            'file_url' => 'nullable|url',
            'preview_url' => 'nullable|url',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|array',
            'thumbnail' => 'nullable|url',
            'images' => 'nullable|array',
            'featured' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $product = Product::create($validator->validated());

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Try numeric ID first, then slug
        $product = Product::where('id', $id)
            ->orWhere('slug', $id)
            ->first();

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:products,slug,'.$product->id,
            'description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'sometimes|nullable|numeric|min:0',
            'stock' => 'sometimes|nullable|integer|min:0',
            'digital' => 'sometimes|required|boolean',
            'file_url' => 'sometimes|nullable|url',
            'preview_url' => 'sometimes|nullable|url',
            'category' => 'sometimes|required|string|max:100',
            'tags' => 'sometimes|nullable|array',
            'thumbnail' => 'sometimes|nullable|url',
            'images' => 'sometimes|nullable|array',
            'featured' => 'sometimes|nullable|boolean',
            'active' => 'sometimes|nullable|boolean',
            'published_at' => 'sometimes|nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $product->update($validator->validated());

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }

        $product->delete(); // Soft delete

        return response()->json(null, 204);
    }
}
