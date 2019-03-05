<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionTest extends TestCase
{
    public function test_can_get_all_province()
    {
        $response = $this->json('GET', route('region.all.province'));
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

    public function test_can_get_all_city()
    {
        $response = $this->json('GET', route('region.all.city'));
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

    public function test_can_get_city_by_selected_province()
    {
        $response = $this->json('GET', route('region.city.by.province', 3));
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
