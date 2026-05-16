<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\Artisan;

class BulkTranslationTest extends TestCase
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
    public function it_can_bulk_auto_translate_translations()
    {
        $translation1 = Translation::create(['key' => 'test_key_1', 'group' => 'test', 'text' => 'Hello']);
        $translation2 = Translation::create(['key' => 'test_key_2', 'group' => 'test', 'text' => 'World']);

        $response = $this->post(route('admin.translations.auto'), [
            'translation_ids' => [$translation1->id, $translation2->id]
        ]);

        $response->assertSuccessful();
        $response->assertJson(['success' => true]);
    }
}
