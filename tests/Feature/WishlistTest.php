<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WishlistTest extends TestCase
{
    public function test_can_browser_wishlist_items()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('GET', route('wishlist.browse'));
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

//    public function test_can_add_new_wishlist_item()
//    {
//        DB::beginTransaction();
//        $response = $this->actingAs($this->user, 'api')
//            ->json('GET', route('wishlist.add', 4));
//        $response->assertStatus(201)
//            ->assertJson(['code' => 201])
//            ->assertJsonStructure([
//                'url',
//                'method',
//                'code',
//                'message',
//                'payload',
//            ]);
//        DB::rollBack();
//    }

//    public function test_can_remove_a_wishlist_item()
//    {
//        DB::beginTransaction();
//        $this->actingAs($this->user, 'api')
//            ->json('GET', route('wishlist.add', 4));
//        $response = $this->actingAs($this->user, 'api')
//            ->json('GET', route('wishlist.remove', 4));
//        $response->assertStatus(200)
//            ->assertJson(['code' => 200])
//            ->assertJsonStructure([
//                'url',
//                'method',
//                'code',
//                'message',
//                'payload',
//            ]);
//        DB::rollBack();
//    }
}
