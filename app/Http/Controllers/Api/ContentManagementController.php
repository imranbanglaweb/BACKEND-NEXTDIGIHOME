<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Models\PageContent;
use App\Models\Product;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentManagementController extends Controller
{
    public function getHomeContent()
    {
        try {
            $data = [
                'hero_sliders' => HeroSlider::active()->ordered()->get(),
                'featured_products' => Product::where('active', true)
                    ->where('featured', true)
                    ->latest()
                    ->take(8)
                    ->get()
                    ->map(fn (Product $product) => $this->formatHomeProduct($product))
                    ->values(),
                'latest_products' => Product::where('active', true)
                    ->latest()
                    ->take(8)
                    ->get()
                    ->map(fn (Product $product) => $this->formatHomeProduct($product))
                    ->values(),
                'stats' => Stat::active()->ordered()->get(),
                'features' => PageContent::page('home')->section('features')->active()->ordered()->get(),
                'how_it_works' => PageContent::page('home')->section('how_it_works')->active()->ordered()->get(),
                'categories' => PageContent::page('home')->section('categories')->active()->ordered()->get(),
                'testimonials' => Testimonial::active()->ordered()->get(),
                'faq' => PageContent::page('home')->section('faq')->active()->ordered()->get(),
                'newsletter' => PageContent::page('home')->section('newsletter')->active()->first(),
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Return empty data if database tables don't exist or other errors
            return response()->json([
                'success' => true,
                'data' => [
                    'hero_sliders' => [],
                    'featured_products' => [],
                    'latest_products' => [],
                    'stats' => [],
                    'features' => [],
                    'how_it_works' => [],
                    'categories' => [],
                    'testimonials' => [],
                    'faq' => [],
                    'newsletter' => null,
                ],
            ]);
        }
    }

    public function getAboutContent()
    {
        $data = [
            'mission' => PageContent::page('about')->section('mission')->active()->first(),
            'vision' => PageContent::page('about')->section('vision')->active()->first(),
            'stats' => PageContent::page('about')->section('stats')->active()->ordered()->get(),
            'team' => TeamMember::active()->ordered()->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function getContactContent()
    {
        $contactInfo = ContactInfo::active()->ordered()->get()->map(function ($info) {
            return [
                'id' => $info->id,
                'type' => $info->type,
                'label' => $info->title,
                'value' => $info->value,
                'description' => $info->description,
                'icon' => $info->icon,
            ];
        });

        $data = [
            'hero' => PageContent::page('contact')->section('hero')->active()->first(),
            'contact_info' => $contactInfo,
            'faq' => PageContent::page('contact')->section('faq')->active()->ordered()->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function getPrivacyContent()
    {
        $content = PageContent::page('privacy')->section('content')->active()->first();

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    public function getTermsContent()
    {
        $content = PageContent::page('terms')->section('content')->active()->first();

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    public function getAllContent()
    {
        $data = [
            'hero_sliders' => HeroSlider::all(),
            'featured_products' => Product::where('active', true)
                ->where('featured', true)
                ->latest()
                ->take(8)
                ->get()
                ->map(fn (Product $product) => $this->formatHomeProduct($product))
                ->values(),
            'page_contents' => PageContent::all(),
            'stats' => Stat::all(),
            'testimonials' => Testimonial::all(),
            'team_members' => TeamMember::all(),
            'contact_info' => ContactInfo::all(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    protected function formatHomeProduct(Product $product): array
    {
        $thumbnailUrl = $this->resolveProductAssetUrl($product->thumbnail);
        $description = trim(strip_tags((string) ($product->description ?: $product->detailed_description)));

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => Str::limit($description, 140),
            'price' => $product->price,
            'compare_price' => $product->compare_price,
            'category' => $product->category,
            'featured' => (bool) $product->featured,
            'thumbnail' => $product->thumbnail,
            'thumbnail_url' => $thumbnailUrl,
            'image_url' => $thumbnailUrl,
            'image_alt' => $product->name,
            'image_display' => [
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
            ],
            'seo' => [
                'title' => $product->seo_title ?: $product->name,
                'description' => $product->seo_description ?: Str::limit($description, 160, ''),
                'canonical_url' => $product->canonical_url ?: url('/products/'.$product->slug),
            ],
        ];
    }

    protected function resolveProductAssetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        return asset('public/storage/'.ltrim($path, '/'));
    }
}
