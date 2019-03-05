<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('permissions')->truncate();
        \Illuminate\Support\Facades\DB::table('permission_role')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $permissions = [
            //core
            'user-management',
            'add-user',
            'edit-user',
            'delete-user',

            //role
            'role-management',
            'add-role',
            'edit-role',
            'delete-role',

            //permission
            'permission-management',
            'edit-permission',
            'set-permission',
        ];


        $currentTime = \Carbon\Carbon::now();
        $permissionsData = [];
        foreach ($permissions as $key => $value) {
            $permissionsData[] = [
                'name' => $value,
                'display_name' => ucwords(str_replace('-' ,' ', $value)),
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ];
        }

        \App\Models\Permission::insert($permissionsData);
        $allPermissions = \App\Models\Permission::all();
        $admin = \App\Models\Role::where('name','admin')->first();
        $admin->attachPermissions($allPermissions);
    }
}
