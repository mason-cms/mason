<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

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
        $this->setupTheme();
    }

    protected function setupTheme()
    {
        $siteTheme = config('site.theme');

        if (! empty($siteTheme)) {
            $siteThemeInfo = explode(':', $siteTheme, 2);
            $siteThemePath = $siteThemeInfo[0];

            if (! empty($siteThemePath)) {
                $viewPaths = config('view.paths');
                $viewPaths[] = base_path("vendor/{$siteThemePath}/resources/views");

                config(['view.paths' => $viewPaths]);
            }
        }
    }
}
