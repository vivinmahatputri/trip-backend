<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        \Illuminate\Support\Facades\DB::table('admins')->truncate();
        \Illuminate\Support\Facades\DB::table('travellers')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $this->call(AdminsTableSeeder::class);
        $this->call(TravellersTableSeeder::class);
    }
}
