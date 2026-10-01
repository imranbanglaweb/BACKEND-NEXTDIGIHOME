<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Fatima Rahman',
                'position' => 'CEO',
                'company' => 'TechStart Inc.',
                'content' => 'The website templates saved us months of development time. Professional quality and easy to customize. Our conversion rate increased by 40%!',
                'rating' => 5,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmed Rahman',
                'position' => 'Marketing Director',
                'company' => 'GrowthCo',
                'content' => 'Outstanding automation tools! We automated our entire lead generation process and saw a 300% increase in qualified leads within 2 months.',
                'rating' => 5,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Ayesha Begum',
                'position' => 'Founder',
                'company' => 'DesignStudio',
                'content' => 'The customer support is exceptional. Every product comes with detailed documentation and the team responds within hours, not days.',
                'rating' => 5,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}