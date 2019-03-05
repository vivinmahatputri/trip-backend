<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Province;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share([
            'destinations' => $this->getDestinationData(),
            'categories' => Category::has('tourisms')->get(),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        if ($this->app->isLocal()) {
        $this->app->register(TelescopeServiceProvider::class);
//    	}
    }

    public function getDestinationData()
    {
        $data = collect();

        $west = collect();
        $provinceWest = Province::whereIn('id', [11,12,13,14,15,16,17,18,19,21,31,32,33,34,35,36,61,62])->get();
        $west->put('name', 'Western Indonesia');
        $west->put('data', $provinceWest);
        $data->push($west);

        $central = collect();
        $provinceCentral = Province::whereIn('id', [51,52,53,63,64,65,71,72,73,74,75,76])->get();
        $central->put('name', 'Central Indonesia');
        $central->put('data', $provinceCentral);
        $data->push($central);

        $east = collect();
        $provinceEast = Province::whereIn('id', [81,82,91,94])->get();
        $east->put('name', 'Eastern Indonesia');
        $east->put('data', $provinceEast);
        $data->push($east);

        return $data;
    }
}
