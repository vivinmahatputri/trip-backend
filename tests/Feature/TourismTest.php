<?php

namespace Tests\Feature;

use Tests\TestCase;

class TourismTest extends TestCase
{
    /** @test */
    public function test_can_get_top_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.top'));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);

    }

    /** @test */
    public function test_can_get_latest_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.latest'));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }

    /** @test */
    public function test_can_get_newest_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.newest'));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }

    /** @test */
    public function test_can_search_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.search', ['q' => 'pantai']));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }

    /** @test */
    public function test_can_advance_search_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.search.advance', ['q' => 'pantai', 'province' => 3, 'city' => 16]));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }

    /** @test */
    public function test_can_search_near_me_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.near.me', ['lon' => 100.368844, 'lat' => -0.3062607]));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }

    public function test_can_show_tourism_destination()
    {
        $response = $this->json('GET', route('tourism.show', 137));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }
}
