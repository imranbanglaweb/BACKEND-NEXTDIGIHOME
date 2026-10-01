<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Artisan;

class LanguageSwitcherTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    public function language_can_be_switched()
    {
        $language = Language::where('code', '!=', app()->getLocale())->first();
        if($language) {
            $response = $this->post(route('admin.language.switch'), ['language' => $language->code]);

            $response->assertSessionHas('locale', $language->code);

            $response->assertRedirect();

            $this->assertEquals($language->code, session('locale'));
        } else {
            $this->assertTrue(true, "No other language to switch to.");
        }
    }
}
