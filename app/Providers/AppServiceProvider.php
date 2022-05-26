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
        $this->setTrustedProxies();
        $this->setupTheme();
    }

    protected function setTrustedProxies()
    {
        $trustedProxies = config('proxy.trusted');

        if (isset($trustedProxies)) {
            $trustedProxies = explode(',', $trustedProxies);

            if (count($trustedProxies) > 0) {
                Request::setTrustedProxies($trustedProxies, config('proxy.header_set'));
            }
        }
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
