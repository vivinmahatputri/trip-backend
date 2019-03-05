<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $pos = strpos(request()->url(), 'www');
        if($pos === false){
            $subdomain = env('APP_URL');
        }
        else{
            $subdomain = env('APP_WWW_URL', 'https://www.wesata.id/');
        }

        Route::middleware('web')
             ->namespace($this->namespace)
             ->domain($subdomain)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */

    protected function mapApiRoutes()
    {
        Route::middleware('api')
             ->namespace($this->namespace)
             ->domain(env('APP_API_URL'))
             ->group(base_path('routes/api.php'));
    }
}
