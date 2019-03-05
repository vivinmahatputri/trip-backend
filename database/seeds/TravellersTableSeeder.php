<?php

use Illuminate\Database\Seeder;

class TravellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $generator)
    {
        $role = \App\Models\Role::where('name', 'traveller')->first();
        for($i = 1; $i <= 15; $i++)
        {
            $traveller = \App\Models\Traveller::create([
                'name' => $generator->name,
                'facebook_username' => null,
                'instagram_username' => null,
                'twitter_username' => null,
                'about_me' => $generator->text,
                'address' => $generator->address,
                'interest' => $generator->text(5),
                'birth_of_date' => $generator->date(),
                'longitude' => $generator->longitude,
                'latitude' => $generator->latitude,
                'is_guide' => false
            ]);

            $user = $traveller->user()->create([
                'username' => strtolower(str_replace(' ', '_', $traveller->name)),
                'email' => $role->name.'_'.$i.'@example.com',
                'password' => bcrypt('12345678'),
            ]);

            $user->attachRole($role);
        }

    }
}
