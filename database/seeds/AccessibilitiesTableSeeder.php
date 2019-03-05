<?php

use Illuminate\Database\Seeder;

class AccessibilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('accessibilities')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $data = [
            ['name' => 'Jalan Kaki'],
            ['name' => 'Sepeda'],
            ['name' => 'Mobil'],
            ['name' => 'Sepeda Motor'],
            ['name' => 'Kapal'],
            ['name' => 'Perahu'],
            ['name' => 'Kereta Api'],
            ['name' => 'Bus Pariwisata'],
            ['name' => 'Angkutan Umum'],
            ['name' => 'Bus'],
            ['name' => 'Delman'],
            ['name' => 'Becak'],
            ['name' => 'Sepeda Motor Trail'],
            ['name' => 'Mobil Jeep'],
        ];

        \App\Models\Accessibility::insert($data);
    }
}
