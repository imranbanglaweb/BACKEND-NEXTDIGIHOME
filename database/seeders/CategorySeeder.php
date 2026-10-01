<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            [
                'category_name' => 'Digital Marketing',
                'category_slug' => 'digital-marketing',
                'remarks' => 'Courses and resources for digital marketing professionals',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Web Development',
                'category_slug' => 'web-development',
                'remarks' => 'Web development tools, templates, and resources',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Graphic Design',
                'category_slug' => 'graphic-design',
                'remarks' => 'Design templates, assets, and creative resources',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Business Tools',
                'category_slug' => 'business-tools',
                'remarks' => 'Productivity tools and business software',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Education',
                'category_slug' => 'education',
                'remarks' => 'Educational content, courses, and learning materials',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Photography',
                'category_slug' => 'photography',
                'remarks' => 'Stock photos, presets, and photography resources',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Music & Audio',
                'category_slug' => 'music-audio',
                'remarks' => 'Music production tools, samples, and audio resources',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Video & Animation',
                'category_slug' => 'video-animation',
                'remarks' => 'Video editing tools, animations, and motion graphics',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Software & Apps',
                'category_slug' => 'software-apps',
                'remarks' => 'Desktop and mobile applications',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Templates',
                'category_slug' => 'templates',
                'remarks' => 'Website templates, themes, and design assets',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('CategorySeeder completed successfully!');
        $this->command->info('Created ' . count($categories) . ' product categories.');
    }
}
