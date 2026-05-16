<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Home page content
            [
                'page' => 'home',
                'section' => 'mission',
                'title' => 'Our Mission',
                'content' => 'To democratize access to premium digital products and empower businesses of all sizes to achieve their full potential through innovative tools and resources.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'features',
                'title' => 'Instant Access',
                'subtitle' => 'Premium Quality',
                'content' => 'Download immediately after purchase - no waiting, no shipping delays. Get started right away.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'features',
                'title' => 'Quality Guaranteed',
                'subtitle' => 'Professional Standards',
                'content' => 'Every product is rigorously tested and optimized for professional use and performance.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'features',
                'title' => '24/7 Support',
                'subtitle' => 'Always Available',
                'content' => 'Our dedicated team is here to help you succeed with any questions or challenges.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'how_it_works',
                'title' => 'Choose Your Product',
                'content' => 'Browse our curated collection of premium digital products. Filter by category, price, or rating to find exactly what you need.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'how_it_works',
                'title' => 'Instant Download',
                'content' => 'Secure payment processing with instant access to your digital products. No shipping delays or waiting periods.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'how_it_works',
                'title' => 'Scale Your Business',
                'content' => 'Implement your new digital assets and watch your business grow. Our 24/7 support team is here to help you succeed.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'faq',
                'title' => 'How quickly can I access my purchased products?',
                'content' => 'Instant access! All digital products are available for immediate download after successful payment. No waiting for shipping or processing.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'newsletter',
                'title' => 'Stay Updated with Latest Products',
                'subtitle' => 'Join our newsletter and be the first to know about new premium digital products, exclusive discounts, and business growth tips.',
                'link_text' => 'Subscribe Now',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // About page content
            [
                'page' => 'about',
                'section' => 'mission',
                'title' => 'Our Mission',
                'content' => 'To democratize access to premium digital products and empower businesses of all sizes to achieve their full potential through innovative tools and resources.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'about',
                'section' => 'vision',
                'title' => 'Our Vision',
                'content' => 'To become the world&apos;s leading marketplace for digital products, where creators and businesses connect to build the future of digital innovation.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Contact page content
            [
                'page' => 'contact',
                'section' => 'hero',
                'title' => 'Get In Touch',
                'content' => 'Get in touch with our expert team. We&apos;re here to help you succeed with premium digital products and solutions.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Privacy page content
            [
                'page' => 'privacy',
                'section' => 'content',
                'title' => 'Privacy Policy',
                'content' => 'This Privacy Policy describes how DigitalHub collects, uses, and protects your personal information when you use our website and services.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Terms page content
            [
                'page' => 'terms',
                'section' => 'content',
                'title' => 'Terms of Service',
                'content' => 'These Terms of Service govern your use of DigitalHub and our digital products. By accessing our services, you agree to these terms.',
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($contents as $content) {
            PageContent::create($content);
        }
    }
}