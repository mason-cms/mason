<?php

namespace App\Providers;

use App\Support\Shortcode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('parser', function () {
            return new \App\Support\Parser;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $shortcodesPath = base_path('shortcodes');

        foreach (glob("{$shortcodesPath}/*.php") as $file) {
            require_once $file;
        }
    }
}
