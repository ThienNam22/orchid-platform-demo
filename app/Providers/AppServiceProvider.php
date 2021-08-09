<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Car;
use App\Models\Company;
use Orchid\Platform\Dashboard;

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
    public function boot(Dashboard $dashboard)
    {
        $dashboard->registerSearch([
            Car::class,
            Company::class
        ]);
    }
}
