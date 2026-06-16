<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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
        $products = Product::orderBy('created_at', 'desc')->paginate(15);
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('active', true)->count(),
            'digital' => Product::where('digital', true)->count(),
            'featured' => Product::where('featured', true)->count(),
        ];
        $categories = Product::query()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.products.index', compact('products', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Models\Category::orderBy('category_name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'digital' => 'required|boolean',
            'product_kind' => ['required', Rule::in(self::PRODUCT_KINDS)],
            'purchase_type' => ['required', Rule::in(self::PURCHASE_TYPES)],
            'validity_days' => 'nullable|integer|min:1|max:36500',
            'validity_label' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'file_url' => 'nullable|url',
            'preview_url' => 'nullable|url',
            'video_type' => 'nullable|string|in:none,youtube,upload',
            'video_url' => 'nullable|string',
            'seo_title' => 'nullable|string|max:70',
            'seo_description' => 'nullable|string|max:170',
            'seo_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:95',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,avi,mov|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_thumbnail_path' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->slug);
        $data = $this->normalizeProductCommercialFields($data);

        // Handle tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Set default values
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['robots_index'] = $request->has('robots_index') ? 1 : 0;
        $data['robots_follow'] = $request->has('robots_follow') ? 1 : 0;

        // Handle images upload first (needed for gallery thumbnail selection)
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products/images', 'public');
            }
            $data['images'] = $images;
        }

        // Handle thumbnail from gallery selection or file upload
        if ($request->filled('selected_thumbnail_path')) {
            $thumbnailPath = $request->input('selected_thumbnail_path');
            if (strpos($thumbnailPath, 'gallery_index_') === 0) {
                $index = intval(str_replace('gallery_index_', '', $thumbnailPath));
                $galleryImages = is_string($data['images'] ?? null) ? json_decode($data['images'], true) : ($data['images'] ?? null);
                if (is_array($galleryImages) && isset($galleryImages[$index])) {
                    $data['thumbnail'] = $galleryImages[$index];
                }
            } else {
                $data['thumbnail'] = $thumbnailPath;
            }
        } elseif ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        // Handle video
        $data['video_type'] = $request->input('video_type', 'none');
        if ($data['video_type'] === 'youtube') {
            $data['video_url'] = $request->input('video_url');
        } elseif ($data['video_type'] === 'upload' && $request->hasFile('video_file')) {
            $data['video_url'] = $request->file('video_file')->store('products/videos', 'public');
        } else {
            $data['video_type'] = 'none';
            $data['video_url'] = null;
        }

        Product::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Product created successfully.']);
        } else {
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'digital' => 'required|boolean',
            'product_kind' => ['required', Rule::in(self::PRODUCT_KINDS)],
            'purchase_type' => ['required', Rule::in(self::PURCHASE_TYPES)],
            'validity_days' => 'nullable|integer|min:1|max:36500',
            'validity_label' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'file_url' => 'nullable|url',
            'preview_url' => 'nullable|url',
            'video_type' => 'nullable|string|in:none,youtube,upload',
            'video_url' => 'nullable|string',
            'seo_title' => 'nullable|string|max:70',
            'seo_description' => 'nullable|string|max:170',
            'seo_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:95',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,avi,mov|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selected_thumbnail_path' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Ensure thumbnail is provided either as file or from gallery (only if product doesn't already have one)
        if (!$product->thumbnail && !$request->hasFile('thumbnail') && !$request->filled('selected_thumbnail_path')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Please provide a thumbnail image by uploading a file or selecting from gallery.'], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Please provide a thumbnail image by uploading a file or selecting from gallery.');
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->slug);
        $data = $this->normalizeProductCommercialFields($data);

        // Handle tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Set checkbox values
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['robots_index'] = $request->has('robots_index') ? 1 : 0;
        $data['robots_follow'] = $request->has('robots_follow') ? 1 : 0;

        // Handle thumbnail from gallery selection or file upload
        if ($request->filled('selected_thumbnail_path')) {
            $thumbnailPath = $request->input('selected_thumbnail_path');
            if (strpos($thumbnailPath, 'gallery_index_') === 0) {
                $index = intval(str_replace('gallery_index_', '', $thumbnailPath));
                $galleryImages = $data['images'] ?? $product->images;
                $galleryImages = is_string($galleryImages) ? json_decode($galleryImages, true) : $galleryImages;
                if (is_array($galleryImages) && isset($galleryImages[$index])) {
                    $data['thumbnail'] = $galleryImages[$index];
                }
            } else {
                $data['thumbnail'] = $thumbnailPath;
            }
        } elseif ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        // Handle images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products/images', 'public');
            }
            $data['images'] = $images;
        }

        // Handle video
        $data['video_type'] = $request->input('video_type', 'none');
        if ($data['video_type'] === 'youtube') {
            $data['video_url'] = $request->input('video_url');
            // optionally delete old uploaded video if switching from upload
            if ($product->video_type === 'upload' && $product->video_url && Storage::disk('public')->exists($product->video_url)) {
                Storage::disk('public')->delete($product->video_url);
            }
        } elseif ($data['video_type'] === 'upload' && $request->hasFile('video_file')) {
            // delete old video file
            if ($product->video_url && Storage::disk('public')->exists($product->video_url)) {
                Storage::disk('public')->delete($product->video_url);
            }
            $data['video_url'] = $request->file('video_file')->store('products/videos', 'public');
        } else {
            // none or switching away
            if ($product->video_url && Storage::disk('public')->exists($product->video_url) && $product->video_type === 'upload') {
                Storage::disk('public')->delete($product->video_url);
            }
            $data['video_type'] = 'none';
            $data['video_url'] = null;
        }

        $product->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Product updated successfully.']);
        } else {
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        }
    }

    /**
     * Get data for DataTables AJAX request
     */
    public function getData(Request $request)
    {
        $query = Product::query()->latest();

        if ($request->filled('status')) {
            $query->where('active', (bool) $request->status);
        }

        if ($request->filled('featured')) {
            $query->where('featured', (bool) $request->featured);
        }

        if ($request->filled('digital')) {
            $query->where('digital', (bool) $request->digital);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('product_kind')) {
            $query->where('product_kind', $request->product_kind);
        }

        if ($request->filled('purchase_type')) {
            $query->where('purchase_type', $request->purchase_type);
        }

        $products = $query->get();

        $data = [];
        foreach ($products as $product) {
            $thumbnail = $product->thumbnail ? '<img src="' . asset('public/storage/' . $product->thumbnail) . '" alt="' . e($product->name) . '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">' : '<div class="bg-light text-center" style="width: 50px; height: 50px; line-height: 50px;"><i class="fas fa-image text-muted"></i></div>';

            $price = '$' . number_format($product->price, 2);
            if ($product->compare_price) {
                $price .= '<br><small class="text-muted"><del>$' . number_format($product->compare_price, 2) . '</del></small>';
            }
            $price .= '<br><small class="text-muted">' . e($product->purchase_type_label) . '</small>';

            $stock = $product->stock > 10 ? '<span class="badge badge-success">In Stock</span>' : ($product->stock > 0 ? '<span class="badge badge-warning">Low Stock</span>' : '<span class="badge badge-danger">Out of Stock</span>');

            $status = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="status-' . $product->id . '" data-id="' . $product->id . '" ' . ($product->active ? 'checked' : '') . '><label class="custom-control-label" for="status-' . $product->id . '"></label></div>';

            $featured = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input featured-toggle" id="featured-' . $product->id . '" data-id="' . $product->id . '" ' . ($product->featured ? 'checked' : '') . '><label class="custom-control-label" for="featured-' . $product->id . '"></label></div>';

            $actions = '<div class="btn-group" role="group">';
            $actions .= '<a href="' . route('admin.products.show', $product) . '" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>';
            $actions .= '<a href="' . route('admin.products.edit', $product) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete-product" data-id="' . $product->id . '" title="Delete"><i class="fas fa-trash"></i></button>';
            $actions .= '</div>';

            $data[] = [
                $product->id,
                $thumbnail,
                e($product->name),
                e($product->category) . '<br><small class="text-muted">' . e($product->product_kind_label) . '</small>',
                $price,
                $stock,
                $status,
                $featured,
                $actions
            ];
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Toggle product status
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->active = !$product->active;
        $product->save();

        return response()->json(['success' => true, 'active' => $product->active]);
    }

    /**
     * Toggle product featured status
     */
    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->featured = !$product->featured;
        $product->save();

        return response()->json(['success' => true, 'featured' => $product->featured]);
    }

    /**
     * Show digital downloads page
     */
    public function downloads()
    {
        $products = Product::with('purchases')->withCount([
            'purchases',
            'purchases as completed_purchases_count' => function ($query) {
                $query->whereIn('status', ['completed', 'delivered', 'processing']);
            },
        ])->where('digital', true)->latest()->get();

        $stats = [
            'digital' => Product::where('digital', true)->count(),
            'with_file' => Product::where('digital', true)->whereNotNull('file_url')->where('file_url', '!=', '')->count(),
            'downloads' => ProductPurchase::sum('download_count'),
            'revenue' => ProductPurchase::whereIn('status', ['completed', 'delivered', 'processing'])->sum('total'),
        ];

        return view('admin.products.downloads', compact('products', 'stats'));
    }

    /**
     * Show product reviews page
     */
    public function reviews()
    {
        $testimonials = Testimonial::ordered()->get();
        $stats = [
            'total' => $testimonials->count(),
            'active' => $testimonials->where('is_active', true)->count(),
            'average' => $testimonials->avg('rating') ? number_format($testimonials->avg('rating'), 1) : '0.0',
            'products' => Product::count(),
        ];

        return view('admin.products.reviews', compact('testimonials', 'stats'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated files
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        if ($product->images) {
            $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
            if (is_array($images)) {
                foreach ($images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
        }

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }

    private function normalizeProductCommercialFields(array $data): array
    {
        $purchaseType = $data['purchase_type'] ?? 'one_time';

        if (! isset($data['validity_days']) || $data['validity_days'] === '') {
            $data['validity_days'] = match ($purchaseType) {
                'monthly_subscription' => 30,
                'yearly_subscription' => 365,
                default => null,
            };
        }

        if (! isset($data['validity_label']) || trim((string) $data['validity_label']) === '') {
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
