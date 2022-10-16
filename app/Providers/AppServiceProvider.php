<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('i', function ($expression) {
            return "<?= i($expression); ?>";
        });

        Blade::directive('icon', function ($expression) {
            return "<?= icon($expression); ?>";
        });
    }
}
