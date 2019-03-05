<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $generator)
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('reviews')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $tourisms = \App\Models\Tourism::all();

        foreach ($tourisms as $tourism){
            $id = rand(1, 15);
            for($i = 0; $i < $id; $i++) {
                $tourism->reviews()->create(
                    [
                        'user_id' => $i+1,
                        'review' => $generator->text,
                        'rating' => rand(1,5)
                    ]
                );
            }
        }

    }
}
