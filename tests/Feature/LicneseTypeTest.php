<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Licnese_type;

class LicneseTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function store_creates_license_type_via_ajax()
    {
        $payload = [
            'type_name' => 'Test Type AJAX',
            'description' => 'Created by feature test',
            'status' => 'Active',
        ];

        $response = $this->postJson(route('license-types.store'), $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'type' => ['id', 'type_name', 'description', 'status']]);

        $this->assertDatabaseHas('licnese_types', ['type_name' => 'Test Type AJAX']);
    }

    /** @test */
    public function store_redirects_on_non_ajax()
    {
        $payload = [
            'type_name' => 'Test Type Web',
            'description' => 'Created by non-AJAX test',
            'status' => 'Active',
        ];

        $response = $this->post(route('license-types.store'), $payload);

        $response->assertRedirect(route('license-types.index'));
        $this->assertDatabaseHas('licnese_types', ['type_name' => 'Test Type Web']);
    }
}
