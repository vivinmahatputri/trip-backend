<?php

use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('ratings')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $tourisms = \App\Models\Tourism::all();

        $users = \App\Models\User::all();

        foreach ($tourisms as $tourism) {
            foreach ($users as $user) {
                $rating = rand(1, 5);
                $tourism->ratings()->create(
                    [
                        'user_id' => $user->id,
                        'rating' => $rating
                    ]
                );
            }
        }
    }
}
