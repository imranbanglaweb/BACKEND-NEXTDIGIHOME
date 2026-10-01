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
                'title' => 'Build. Launch. Automate. Grow.',
                'subtitle' => 'Technology, AI & Software Ecosystem',
                'description' => 'We architect high-performance web applications, autonomous AI agents, performance growth marketing, and enterprise SaaS platforms.',
                'cta_text' => 'Explore Solutions',
                'cta_link' => '/solutions',
                'image' => 'https://via.placeholder.com/400x300/00d4aa/ffffff?text=Build+Launch+Automate+Grow',
                'background_color' => '#07090e',
                'text_color' => '#fafafa',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'NextDigi Solutions',
                'subtitle' => 'Custom Software & Web Engineering',
                'description' => 'Modern headless commerce, Flutter mobile apps, custom enterprise ERPs, and scalable SaaS infrastructure.',
                'cta_text' => 'Start a Project',
                'cta_link' => '/contact',
                'image' => 'https://via.placeholder.com/400x300/8b5cf6/ffffff?text=NextDigi+Solutions',
                'background_color' => '#07090e',
                'text_color' => '#fafafa',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'NextDigi AI & Labs',
                'subtitle' => 'Intelligent Agents & SaaS Platforms',
                'description' => 'Autonomous task agents, bilingual customer chatbots, workflow automation, and proprietary SaaS platforms.',
                'cta_text' => 'Explore AI Division',
                'cta_link' => '/ai',
                'image' => 'https://via.placeholder.com/400x300/38bdf8/ffffff?text=NextDigi+AI',
                'background_color' => '#07090e',
                'text_color' => '#fafafa',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlider::updateOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }
    }
}
