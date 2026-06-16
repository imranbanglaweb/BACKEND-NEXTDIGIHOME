<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private const PRODUCT_KINDS = [
        'digital_download',
        'website_template',
        'ecommerce_template',
        'saas',
        'course',
        'service',
        'physical',
        'other',
    ];

    private const PURCHASE_TYPES = [
        'one_time',
        'monthly_subscription',
        'yearly_subscription',
        'lifetime',
    ];

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
            ->when(request('product_kind'), function($query) {
                return $query->where('product_kind', request('product_kind'));
            })
            ->when(request('purchase_type'), function($query) {
                return $query->where('purchase_type', request('purchase_type'));
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
            'product_kind' => 'nullable|string|in:' . implode(',', self::PRODUCT_KINDS),
            'purchase_type' => 'nullable|string|in:' . implode(',', self::PURCHASE_TYPES),
            'validity_days' => 'nullable|integer|min:1|max:36500',
            'validity_label' => 'nullable|string|max:100',
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

        $product = Product::create($this->normalizeProductCommercialFields($validator->validated()));

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
            'product_kind' => 'sometimes|nullable|string|in:' . implode(',', self::PRODUCT_KINDS),
            'purchase_type' => 'sometimes|nullable|string|in:' . implode(',', self::PURCHASE_TYPES),
            'validity_days' => 'sometimes|nullable|integer|min:1|max:36500',
            'validity_label' => 'sometimes|nullable|string|max:100',
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

        $product->update($this->normalizeProductCommercialFields($validator->validated(), $product));

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
        $robotsMeta = ($robotsIndex ? 'index' : 'noindex') . ', ' . ($robotsFollow ? 'follow' : 'nofollow');

        $data['thumbnail_url'] = $thumbnailUrl;
        $data['image_url'] = $thumbnailUrl;
        $data['image_urls'] = $imageUrls;
        $data['gallery'] = collect($imageUrls)
            ->map(fn ($imageUrl) => [
                'url' => $imageUrl,
                'alt' => $product->name,
            ])
            ->prepend([
                'url' => $thumbnailUrl,
                'alt' => $product->name,
            ])
            ->filter(fn ($image) => ! empty($image['url']))
            ->values()
            ->all();
        $data['image_display'] = [
            'width' => 900,
            'height' => 675,
            'aspect_ratio' => '4/3',
            'object_fit' => 'cover',
            'sizes' => '(max-width: 640px) 86vw, (max-width: 1024px) 42vw, 320px',
            'container' => [
                'width' => '100%',
                'max_width' => '360px',
                'min_width' => '0',
            ],
        ];
        $data['video_url_resolved'] = $product->video_type === 'upload'
            ? $this->resolveProductAssetUrl($product->video_url)
            : $product->video_url;
        $data['product_kind_label'] = $product->product_kind_label;
        $data['purchase_type_label'] = $product->purchase_type_label;
        $data['access_label'] = $product->access_label;
        $data['commercial'] = [
            'product_kind' => $product->product_kind,
            'product_kind_label' => $product->product_kind_label,
            'purchase_type' => $product->purchase_type,
            'purchase_type_label' => $product->purchase_type_label,
            'validity_days' => $product->validity_days,
            'validity_label' => $product->validity_label,
            'access_label' => $product->access_label,
        ];

        $data['seo'] = [
            'title' => $metaTitle,
            'description' => $metaDescription,
            'keywords' => $product->seo_keywords,
            'canonical_url' => $canonicalUrl,
            'raw' => [
                'seo_title' => $product->seo_title,
                'seo_description' => $product->seo_description,
                'seo_keywords' => $product->seo_keywords,
                'canonical_url' => $product->canonical_url,
                'og_title' => $product->og_title,
                'og_description' => $product->og_description,
                'og_image' => $product->og_image,
                'robots_index' => $robotsIndex,
                'robots_follow' => $robotsFollow,
            ],
            'meta_tags' => [
                'title' => $metaTitle,
                'description' => $metaDescription,
                'keywords' => $product->seo_keywords,
                'canonical' => $canonicalUrl,
                'robots' => $robotsMeta,
            ],
            'robots' => [
                'index' => $robotsIndex,
                'follow' => $robotsFollow,
                'meta' => $robotsMeta,
            ],
            'open_graph' => [
                'title' => $ogTitle,
                'description' => $ogDescription,
                'image' => $ogImage,
                'image_alt' => $product->name,
                'site_name' => config('app.name', 'Next Digi Home'),
                'type' => 'product',
                'url' => $canonicalUrl,
            ],
            'twitter' => [
                'card' => $ogImage ? 'summary_large_image' : 'summary',
                'title' => $ogTitle,
                'description' => $ogDescription,
                'image' => $ogImage,
            ],
            'structured_data' => [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->name,
                'description' => $metaDescription,
                'image' => array_values(array_filter(array_merge([$ogImage], $imageUrls))),
                'sku' => (string) $product->id,
                'category' => $product->category,
                'brand' => [
                    '@type' => 'Brand',
                    'name' => config('app.name', 'Next Digi Home'),
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'url' => $canonicalUrl,
                    'priceCurrency' => 'USD',
                    'price' => number_format((float) $product->price, 2, '.', ''),
                    'availability' => $product->stock > 0
                        ? 'https://schema.org/InStock'
                        : 'https://schema.org/OutOfStock',
                    'itemCondition' => 'https://schema.org/NewCondition',
                ],
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

    private function normalizeProductCommercialFields(array $data, ?Product $product = null): array
    {
        $purchaseType = $data['purchase_type'] ?? $product?->purchase_type ?? 'one_time';
        $data['product_kind'] = $data['product_kind'] ?? $product?->product_kind ?? 'digital_download';
        $data['purchase_type'] = $purchaseType;

        if (! array_key_exists('validity_days', $data) || $data['validity_days'] === '') {
            $data['validity_days'] = match ($purchaseType) {
                'monthly_subscription' => 30,
                'yearly_subscription' => 365,
                default => null,
            };
        }

        if (! array_key_exists('validity_label', $data) || trim((string) $data['validity_label']) === '') {
            $data['validity_label'] = match ($purchaseType) {
                'monthly_subscription' => 'Valid for 1 month',
                'yearly_subscription' => 'Valid for 1 year',
                'lifetime' => 'Lifetime validity',
                default => 'One-time purchase',
            };
        }

        return $data;
    }
}
