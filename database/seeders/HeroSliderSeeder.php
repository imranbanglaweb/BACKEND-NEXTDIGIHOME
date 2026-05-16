<?php

namespace Database\Seeders;

use App\Models\HeroSlider;
use Illuminate\Database\Seeder;

class HeroSliderSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Launch Your Business',
                'subtitle' => 'With Premium Tools',
                'description' => 'Curated collection of premium digital products designed to accelerate your business growth. Templates, tools, and resources trusted by industry leaders.',
                'cta_text' => 'Explore Products',
                'cta_link' => '/products',
                'image' => 'https://via.placeholder.com/400x300/00d4aa/ffffff?text=Launch+Business',
                'background_color' => '#0f0f12',
                'text_color' => '#fafafa',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Scale Your Operations',
                'subtitle' => 'With Smart Automation',
                'description' => 'Powerful automation tools and workflows that streamline your business processes. Save time, reduce costs, and focus on what matters most.',
                'cta_text' => 'View Solutions',
                'cta_link' => '/products',
                'image' => 'https://via.placeholder.com/400x300/8b5cf6/ffffff?text=Smart+Automation',
                'background_color' => '#0f0f12',
                'text_color' => '#fafafa',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Build Professional Brands',
                'subtitle' => 'With Premium Templates',
                'description' => 'Stunning website templates, presentation decks, and brand materials that make your business look professional and trustworthy.',
                'cta_text' => 'Browse Templates',
                'cta_link' => '/products',
                'image' => 'https://via.placeholder.com/400x300/ff6b9d/ffffff?text=Premium+Templates',
                'background_color' => '#0f0f12',
                'text_color' => '#fafafa',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlider::create($slide);
        }
    }
}