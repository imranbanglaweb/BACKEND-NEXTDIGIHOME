<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Models\PageContent;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContentManagementController extends Controller
{
    public function getHomeContent()
    {
        try {
            $data = [
                'hero_sliders' => HeroSlider::active()->ordered()->get(),
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
}