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
        $siteTheme = config('site.theme');

        if (! empty($siteTheme)) {
            $siteThemeInfo = explode(':', $siteTheme, 2);
            $siteThemePath = $siteThemeInfo[0];

            if (! empty($siteThemePath)) {
                $viewPaths = config('view.paths');
                $viewPaths[] = base_path("vendor/{$siteThemePath}/views");
                config(['view.paths' => $viewPaths]);
            }
        }
    }
}
