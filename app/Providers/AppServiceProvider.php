<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

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
        if ($theme = Setting::get('theme')) {
            $viewPaths = config('view.paths');
            $viewPaths[] = base_path("vendor/{$theme}/views");
            config(['view.paths' => $viewPaths]);
        }
    }
}
