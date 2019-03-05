<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $faker;
    protected $user;
    protected $picture;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->user = User::find(2);
        $this->picture = UploadedFile::fake()->image('pantai.jpg');
    }
}
