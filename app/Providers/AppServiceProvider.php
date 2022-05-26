<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            $this->forceHttps();
        }

        $this->setupTheme();
    }

    protected function forceHttps()
    {
        URL::forceScheme('https');
    }

    protected function setupTheme()
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
