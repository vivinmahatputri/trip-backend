<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('roles')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $currentTime = \Carbon\Carbon::now();
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Calestial Dragon',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'name' => 'traveller',
                'display_name' => 'Traveller',
                'description' => 'Pirates',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];

        \Zizaco\Entrust\EntrustRole::insert($roles);
    }
}
