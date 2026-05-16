<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VapidKeysTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_vapid_keys_are_configured()
    {
        $this->assertNotEmpty(config('webpush.vapid.public_key'));
        $this->assertNotEmpty(config('webpush.vapid.private_key'));
    }
}
