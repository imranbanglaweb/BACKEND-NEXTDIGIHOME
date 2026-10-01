<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMembersSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Imran Rahman',
                'position' => 'CEO',
                'bio' => 'Visionary leader driving digital innovation and business growth. Expert in strategic planning and team leadership.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Bristy Akter',
                'position' => 'Operations Manager',
                'bio' => 'Expert in streamlining operations and enhancing team productivity. Skilled in process optimization and project management.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Inaya',
                'position' => 'Marketing Specialist',
                'bio' => 'Creative marketing professional driving brand awareness and engagement. Expert in digital marketing strategies and content creation.',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }
    }
}