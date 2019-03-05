<?php

use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('trips')->truncate();
        \Illuminate\Support\Facades\DB::table('trip_items')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $tourisms = \App\Models\Tourism::all();

        $users = \App\Models\Traveller::all();

        foreach ($users as $traveler){
            $traveler->user->trips()->create([
                'name' => 'Trip planner by '. $traveler->name,
                'description' => 'This trip planner is created by '. $traveler->name,
                'budged_estimation' => rand(100000, 10000000),
                'time_estimation' => rand(1, 10) . ' Jam',
            ]);
        }

        $trips = \App\Models\Trip::all();

        foreach ($trips as $trip){
            $i = 1;
            while ($i < 10) {
                $tourism = \App\Models\Tourism::inRandomOrder()->first();
                $trip->tripItems()->create([
                    'tourism_id' => $tourism->id,
                    'order_number' => $i
                ]);

                $i++;
            }
        }
    }
}
