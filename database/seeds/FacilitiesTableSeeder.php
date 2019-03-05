<?php

use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('facilities')->truncate();
        \Illuminate\Support\Facades\DB::table('facility_groups')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $group = [
            'Fasilitas Umum',
            'Fasilitas Penunjang',
            'Fasilitas Wisata',
            'Kebutuhan Masyarakat Banyak',
            'Prasarana Kepariwisataan',
        ];

        foreach ($group as $datum) {
            \App\Models\FacilityGroup::create([
                'name' => $datum
            ]);
        }

        $data = [
            [
                'facility_group_id' => 1,
                'name' => 'Jaringan air bersih'
            ],
            [
                'facility_group_id' => 1,
                'name' => 'Jaringan listrik'
            ],
            [
                'facility_group_id' => 1,
                'name' => 'Jaringan jalan'
            ],
            [
                'facility_group_id' => 1,
                'name' => 'Jaringan telekomunikasi & internet'
            ],

            [
                'facility_group_id' => 1,
                'name' => 'Pelabuhan'
            ],

            [
                'facility_group_id' => 1,
                'name' => 'Terminal'
            ],

            [
                'facility_group_id' => 1,
                'name' => 'Stasiun KA'
            ],

            [
                'facility_group_id' => 2,
                'name' => 'Rumah Sakit'
            ],
            [
                'facility_group_id' => 2,
                'name' => 'Puskesmas'
            ],
            [
                'facility_group_id' => 2,
                'name' => 'Apotek'
            ],
            [
                'facility_group_id' => 2,
                'name' => 'Pusat perdagangan'
            ],
            [
                'facility_group_id' => 2,
                'name' => 'ATM'
            ],
            [
                'facility_group_id' => 3,
                'name' => 'Kantor informasi'
            ],
            [
                'facility_group_id' => 3,
                'name' => 'Tempat promosi'
            ],
            [
                'facility_group_id' => 3,
                'name' => 'Tempat rekreasi'
            ],
            [
                'facility_group_id' => 3,
                'name' => 'Pengawas pantai'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Hotel'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Motel'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Wisma'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Homestay'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Cottages'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Camping'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Rumah makan'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Restoran'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Cafetaria'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Coffee shop'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Grill room'
            ],
            [
                'facility_group_id' => 5,
                'name' => 'Bar'
            ],
        ];

        \App\Models\Facility::insert($data);

    }
}
