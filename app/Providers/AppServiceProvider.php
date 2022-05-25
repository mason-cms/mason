<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        if ($siteTheme = config('site.theme')) {
            list($siteThemePath, $siteThemeVersion) = explode(':', $siteTheme, 2);
            $viewPaths = config('view.paths');
            $viewPaths[] = base_path("vendor/{$siteThemePath}/views");
            config(['view.paths' => $viewPaths]);
        }
    }
}
