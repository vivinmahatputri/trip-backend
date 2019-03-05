<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_get_access_token()
    {
        $response = $this
            ->json('POST', route('auth.token'), [
                'email' => 'traveller_1@example.com',
                'password' => '12345678'
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ]);
    }

    public function test_can_get_authenticated_user()
    {
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('GET', route('auth.me'));

        $response
            ->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
    }

    public function test_can_register_new_user()
    {
        DB::beginTransaction();
        $response = $this
            ->json('POST', route('auth.register'), [
                'email' => $this->faker->email,
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'username' => $this->faker->username,
                'name' => $this->faker->name,
            ]);

        $response
            ->assertStatus(201)
            ->assertJson(['code' => 201])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
        DB::rollBack();
    }

    public function test_can_update_profile_info()
    {
        DB::beginTransaction();
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('PUT', route('auth.update.info'), [
                'name' => $this->faker->name,
                'about_me' => '',
                'address' => '',
                'interest' => '',
                'birth_of_date' => $this->faker->date
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
        DB::rollBack();
    }

    public function test_can_update_profile_picture()
    {
        DB::beginTransaction();
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('POST', route('auth.update.picture'), [
                'picture' => $this->picture
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(['code' => 200])
            ->assertJsonStructure([
                'url',
                'method',
                'code',
                'message',
                'payload',
            ]);
        DB::rollBack();
    }
}
