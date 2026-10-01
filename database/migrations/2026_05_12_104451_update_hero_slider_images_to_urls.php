<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update emoji images to placeholder URLs
        DB::table('hero_sliders')->where('image', '🎯')->update([
            'image' => 'https://via.placeholder.com/400x300/00d4aa/ffffff?text=Launch+Business',
        ]);

        DB::table('hero_sliders')->where('image', '🚀')->update([
            'image' => 'https://via.placeholder.com/400x300/8b5cf6/ffffff?text=Smart+Automation',
        ]);

        DB::table('hero_sliders')->where('image', '🎨')->update([
            'image' => 'https://via.placeholder.com/400x300/ff6b9d/ffffff?text=Premium+Templates',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to emojis
        DB::table('hero_sliders')->where('image', 'https://via.placeholder.com/400x300/00d4aa/ffffff?text=Launch+Business')->update([
            'image' => '🎯',
        ]);

        DB::table('hero_sliders')->where('image', 'https://via.placeholder.com/400x300/8b5cf6/ffffff?text=Smart+Automation')->update([
            'image' => '🚀',
        ]);

        DB::table('hero_sliders')->where('image', 'https://via.placeholder.com/400x300/ff6b9d/ffffff?text=Premium+Templates')->update([
            'image' => '🎨',
        ]);
    }
};
