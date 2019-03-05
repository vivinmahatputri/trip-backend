<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(\Laravolt\Indonesia\Seeds\ProvincesSeeder::class);
        $this->call(\Laravolt\Indonesia\Seeds\CitiesSeeder::class);
        $this->call(\Laravolt\Indonesia\Seeds\DistrictsSeeder::class);
        $this->call(\Laravolt\Indonesia\Seeds\VillagesSeeder::class);
        $this->call(TourismsTableSeeder::class);
        $this->call(FacilitiesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
//        $this->call(DummiesTablesSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
        $this->call(TripsTableSeeder::class);
        $this->call(SubmissionsTableSeeder::class);
//        $this->call(TourismSubmissionSeeder::class);
        $this->call(HotelsScrapper::class);
        $this->call(PictureScrapper::class);
    }
}
