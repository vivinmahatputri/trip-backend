<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $data = [
            'Air Terjun',
            'Goa',
            'Pantai',
            'Danau',
            'Perbukitan',
            'Pergunungan',
            'Perkampungan',
            'Resor',
            'Benteng',
            'Waduk',
            'Wisata Malam',
            'Wisata Dibawah Air',
            'Taman Hiburan',
            'Taman Nasional',
            'Pasar',
            'Situs Purbakala',
            'Kebun Binatang',
            'Wisata Religi',
            'Wisata Budaya',
            'Wisata Sejarah',
            'Wisata Alam',
            'Taman Wisata',
            'Hutan Wisata'
        ];

        foreach ($data as $datum){
            \App\Models\Category::create([
                'name' => $datum
            ]);
        }

        $pantai = \App\Models\Tourism::withoutGlobalScopes()->where('name', 'LIKE', '%pantai%')->get();
        foreach ($pantai as $item){
            $item->categories()->attach(3);
        }

        $gunung = \App\Models\Tourism::withoutGlobalScopes()->where('name', 'LIKE', '%gunung%')->get();
        foreach ($gunung as $item){
            $item->categories()->attach(6);
        }

        $masjis = \App\Models\Tourism::withoutGlobalScopes()->where('name', 'LIKE', '%bukit%')
            ->get();
        foreach ($masjis as $item){
            $item->categories()->attach(5);
        }

    }
}
