<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $generator)
    {
        $role = \App\Models\Role::where('name', 'admin')->first();

        $admin = \App\Models\Admin::create([
            'name' => $generator->name,
            'address' => $generator->address,
            'phone_number' => $generator->phoneNumber,
        ]);

        $user = $admin->user()->create([
            'username' => $role->name,
            'email' => $role->name . '@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->attachRole($role);
    }
}
