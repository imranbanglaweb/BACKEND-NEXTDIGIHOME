<?php

namespace Tests\Feature;

use App\Models\RequisitionLoghistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dashboard_is_accessible_to_logged_in_user()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a dummy log history to ensure the timeline section has data
        RequisitionLoghistory::factory()->create(['created_by' => $user->id]);

        // Acting as the user
        $response = $this->actingAs($user)->get('/');

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert that the rendered view is the dashboard
        $response->assertViewIs('admin.dashboard.admin.dashboard');

        // Assert that the timeline data is passed and contains the 'action_type'
        $response->assertViewHas('timeline', function ($timeline) {
            return $timeline->every(function ($item) {
                return property_exists($item, 'action_type');
            });
        });
    }
}
