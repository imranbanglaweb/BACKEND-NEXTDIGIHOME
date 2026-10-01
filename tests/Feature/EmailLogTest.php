<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class EmailLogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_email_log_route_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/emaillogs');

        $response->assertStatus(200);
    }
}