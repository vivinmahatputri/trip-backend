<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionTest extends TestCase
{
    public function test_can_submit_new_picture()
    {
        DB::beginTransaction();
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('POST', route('submission.create', ['type' => 'picture']), [
                'tourism_id' => 137,
                'picture' => $this->picture,
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

    public function test_can_submit_new_tourism()
    {
        DB::beginTransaction();
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('POST', route('submission.create', ['type' => 'tourism']), [
                'province_id' => 3,
                'city_id' => 17,
                'name' => $this->faker->name,
                'longitude' => "12345676",
                'latitude' => "65432154",
                'picture' => $this->picture,
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

    public function test_can_submit_new_event()
    {
        DB::beginTransaction();
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('POST', route('submission.create', ['type' => 'event']), [
                'tourism_id' => 137,
                'title' =>'malam bainai',
                'description' =>'mantul',
                'start_date' => '2018-09-15 15:45:08',
                'end_date' => '2018-09-15 15:45:08',
                'eo_name' => $this->faker->name,
                'eo_phone' => $this->faker->phoneNumber,
                'eo_email' => $this->faker->email,
                'picture' => $this->picture
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

    public function test_can_submit_new_review()
    {
        DB::beginTransaction();
        $response = $this
            ->actingAs($this->user, 'api')
            ->json('POST', route('submission.create', ['type' => 'review']), [
                'tourism_id' => 137,
                'review' => 'wah mantap bener ini lokasi',
                'rating' => 4.5
            ]);

        $response
            ->assertStatus(201)
            ->assertJson(['code' => 201 ])
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
