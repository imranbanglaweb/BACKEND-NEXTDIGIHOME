<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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

        $products->getCollection()->transform(function ($product) {
            return $this->formatProductForFrontend($product);
        });

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
            'seo_title' => 'nullable|string|max:70',
            'seo_description' => 'nullable|string|max:170',
            'seo_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:95',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|url|max:255',
            'robots_index' => 'nullable|boolean',
            'robots_follow' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $product = Product::create($validator->validated());

        return response()->json($this->formatProductForFrontend($product), 201);
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

        return response()->json($this->formatProductForFrontend($product));
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
            'seo_title' => 'sometimes|nullable|string|max:70',
            'seo_description' => 'sometimes|nullable|string|max:170',
            'seo_keywords' => 'sometimes|nullable|string|max:500',
            'canonical_url' => 'sometimes|nullable|url|max:255',
            'og_title' => 'sometimes|nullable|string|max:95',
            'og_description' => 'sometimes|nullable|string|max:200',
            'og_image' => 'sometimes|nullable|url|max:255',
            'robots_index' => 'sometimes|nullable|boolean',
            'robots_follow' => 'sometimes|nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $product->update($validator->validated());

        return response()->json($this->formatProductForFrontend($product->fresh()));
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

    /**
     * Format product data for frontend product listing/detail pages.
     */
    protected function formatProductForFrontend(Product $product): array
    {
        $data = $product->toArray();

        $thumbnailUrl = $this->resolveProductAssetUrl($product->thumbnail);
        $imageUrls = collect($product->images ?: [])
            ->map(fn ($image) => $this->resolveProductAssetUrl($image))
            ->filter()
            ->values()
            ->all();

        $description = trim(strip_tags((string) ($product->description ?: $product->detailed_description)));
        $metaDescription = $product->seo_description ?: Str::limit($description, 160, '');
        $metaTitle = $product->seo_title ?: $product->name;
        $canonicalUrl = $product->canonical_url ?: url('/products/' . $product->slug);
        $ogTitle = $product->og_title ?: $metaTitle;
        $ogDescription = $product->og_description ?: $metaDescription;
        $ogImage = $product->og_image ?: $thumbnailUrl;
        $robotsIndex = (bool) ($product->robots_index ?? true);
        $robotsFollow = (bool) ($product->robots_follow ?? true);

        $data['thumbnail_url'] = $thumbnailUrl;
        $data['image_urls'] = $imageUrls;
        $data['video_url_resolved'] = $product->video_type === 'upload'
            ? $this->resolveProductAssetUrl($product->video_url)
            : $product->video_url;

        $data['seo'] = [
            'title' => $metaTitle,
            'description' => $metaDescription,
            'keywords' => $product->seo_keywords,
            'canonical_url' => $canonicalUrl,
            'robots' => [
                'index' => $robotsIndex,
                'follow' => $robotsFollow,
                'meta' => ($robotsIndex ? 'index' : 'noindex') . ', ' . ($robotsFollow ? 'follow' : 'nofollow'),
            ],
            'open_graph' => [
                'title' => $ogTitle,
                'description' => $ogDescription,
                'image' => $ogImage,
                'type' => 'product',
                'url' => $canonicalUrl,
            ],
            'twitter' => [
                'card' => $ogImage ? 'summary_large_image' : 'summary',
                'title' => $ogTitle,
                'description' => $ogDescription,
                'image' => $ogImage,
            ],
        ];

        return $data;
    }

    protected function resolveProductAssetUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        return asset('public/storage/' . ltrim($path, '/'));
    }
}
