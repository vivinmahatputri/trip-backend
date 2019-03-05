<?php

use Illuminate\Database\Seeder;

class DummiesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('pictures')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        $user = \App\Models\User::find(1);
        $create =  new \App\Services\SubmissionService($user);
        $tourism = \App\Models\Tourism::find(137);
        $pictures = [
            'abc.jpg', 'adtwaybudj.jpg', 'auwdhuawdg.jpg'
        ];

        foreach ($pictures as $picture) {
            $tourism->pictures()->create(
                [
                    'file_name' => $picture
                ]
            );
        }


        foreach ($tourism->pictures as $picture)
        {
            $id = rand(1, 15);
            $user = \App\Models\User::find($id);
            $picture->submission()->create(
                [
                    'user_id' => $user->id,
                    'status' => 'processed'
                ]
            );
        }
    }
}
