<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
public function test_the_application_returns_a_successful_response()
{
    // /api/ping に修正
    $response = $this->get('/api/ping');
    $response->assertStatus(200)
             ->assertSeeText('pong');
}
}