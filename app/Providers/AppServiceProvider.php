<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('hospitalName', 'Moulvibazar Al-Falah Hospital');
        view()->share('hospitalAddress', '52, Shamsher Nagar Road, Moulvibazar');
        view()->share('hospitalPhone', '01714-363944');

        Schema::defaultStringLength(191);

    }
}
