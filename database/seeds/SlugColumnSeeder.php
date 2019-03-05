<?php

use Illuminate\Database\Seeder;

class SlugColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tourisms = \App\Models\Tourism::withoutGlobalScopes()->get();
        foreach ($tourisms as $tourism)
        {
            $tourism->slug = str_slug($tourism->name);
            $tourism->save();
        }
    }
}
