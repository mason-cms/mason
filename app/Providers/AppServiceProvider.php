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
        $this->setTrustedProxy();
        $this->setupTheme();
    }

    protected function setTrustedProxy()
    {
        if (config('proxy.enabled')) {
            $proxies = explode(',', config('proxy.list'));

            if (count($proxies) > 0) {
                Request::setTrustedProxies($proxies, config('proxy.header_set'));
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
                $viewPaths[] = base_path("vendor/{$siteThemePath}/views");

                config(['view.paths' => $viewPaths]);
            }
        }
    }
}
