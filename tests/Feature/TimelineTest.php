<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimelineTest extends TestCase
{
    /**
     * Fresh timeline public
     */
    public function test_can_get_public_fresh_post(){
        $response = $this->json('GET', route('timeline.public.fresh'));
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

    public function test_can_get_public_fresh_tourism_post(){
        $response = $this->json('GET', route('timeline.public.fresh',['type' => 'tourism']));
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

    public function test_can_get_public_fresh_picture_post(){
        $response = $this->json('GET', route('timeline.public.fresh',['type' => 'picture']));
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

    public function test_can_get_public_fresh_event_post(){
        $response = $this->json('GET', route('timeline.public.fresh',['type' => 'event']));
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

    /**
     * Trending timeline public
     */
    public function test_can_get_public_trending_post(){
        $response = $this->json('GET', route('timeline.public.trending'));
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

    public function test_can_get_public_trending_tourism_post(){
        $response = $this->json('GET', route('timeline.public.trending',['type' => 'tourism']));
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

    public function test_can_get_public_trending_picture_post(){
        $response = $this->json('GET', route('timeline.public.trending',['type' => 'picture']));
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

    public function test_can_get_public_trending_event_post(){
        $response = $this->json('GET', route('timeline.public.trending',['type' => 'event']));
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

    /**
     * Fresh timeline auth
     */
    public function test_can_get_auth_fresh_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.fresh'));
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

    public function test_can_get_auth_fresh_tourism_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.fresh', ['type' => 'tourism']));
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

    public function test_can_get_auth_fresh_picture_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.fresh', ['type' => 'picture']));
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

    public function test_can_get_auth_fresh_event_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.fresh', ['type' => 'event']));
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

    /**
     * Trending timeline auth
     */
    public function test_can_get_auth_trending_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.trending'));
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

    public function test_can_get_auth_trending_tourism_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.trending', ['type' => 'tourism']));
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

    public function test_can_get_auth_trending_picture_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.trending', ['type' => 'picture']));
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

    public function test_can_get_auth_trending_event_post(){
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('timeline.auth.trending', ['type' => 'event']));
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
