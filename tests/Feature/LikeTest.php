<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{
    public function test_can_like_a_submission()
    {
//        DB::beginTransaction();
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('like.submission', 1));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
//        DB::rollBack();
    }

    public function test_can_dislike_a_submission()
    {
//        DB::beginTransaction();
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('dislike.submission', 1));
        $response->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
//        DB::rollBack();
    }
}
