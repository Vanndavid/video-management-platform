<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    /** @test */
    public function health_endpoint_returns_ok(): void
    {
        $response = $this->get('/api/health');

        $response->assertStatus(200)
                 ->assertJson(['ok' => true]);
    }
}
