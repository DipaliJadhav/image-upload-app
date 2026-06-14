<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ImageApp;

class FeedTest extends TestCase
{
    use RefreshDatabase;
    public function test_authenticated_user_can_view_feed()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/feed');

        $response->assertOk();
    }

    public function test_feed_returns_images()
    {
        $user = User::factory()->create();

        ImageApp::factory()->count(3)->create();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/feed');

        $response->assertOk();

        $response->assertJsonCount(3, 'data');
    }

    public function test_unauthenticated_user_cannot_view_feed()
    {
        $response = $this->getJson('/api/feed');

        $response->assertStatus(401);
    }

    public function test_feed_is_paginated()
    {
        $user = User::factory()->create();

        ImageApp::factory()->count(15)->create();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/feed');

        $response->assertOk();

        $response->assertJsonPath(
            'current_page',
            1
        );

        $response->assertJsonPath(
            'per_page',
            5
        );
    }
}
