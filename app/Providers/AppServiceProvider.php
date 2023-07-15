<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Ini untuk nambah macro biar bisa nambah deskripsi
        Route::macro('routeTitle', function($value) {
            $this->action['title'] = $value;

            return $this;
        });

        Route::macro('getRouteTitle', function() {
            return $this->getAction('title');
        });
    }
}
