<?php

namespace App\Providers;

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
        \Parser::registerShortcode('media-url', function (array $parameters = []) {
            if (isset($parameters['id'])) {
                if ($medium = site()->medium($parameters['id'])) {
                    return $medium->url;
                }
            } elseif (isset($parameters['title'])) {
                if ($medium = site()->media()->byTitle($parameters['title'])->first()) {
                    return $medium->url;
                }
            }

            return '';
        });
    }
}
