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
                $medium = site()->medium($parameters['id']);
            } elseif (isset($parameters['title'])) {
                $medium = site()->media()->byTitle($parameters['title'])->first();
            }

            return isset($medium)
                ? $medium->url
                : "";
        });

        \Parser::registerShortcode('media', function (array $parameters = []) {
            if (isset($parameters['id'])) {
                $medium = site()->medium($parameters['id']);
            } elseif (isset($parameters['title'])) {
                $medium = site()->media()->byTitle($parameters['title'])->first();
            }

            if (isset($medium)) {
                if ($medium->is_image) {
                    $class = $parameters['class'] ?? '';
                    $width = $parameters['width'] ?? $medium->image_width;
                    $height = $parameters['height'] ?? $medium->image_height;
                    $alt = $parameters['alt'] ?? '';
                    $loading = $parameters['loading'] ?? 'lazy';

                    if (isset($parameters['width'], $parameters['height'])) {
                        $width = $parameters['width'];
                        $height = $parameters['height'];
                    } elseif (isset($parameters['width'])) {
                        $width = $parameters['width'];

                        if (isset($medium->image_width, $medium->image_height) && $medium->image_width > 0) {
                            $ratio = $width / $medium->image_width;
                            $height = $medium->image_height * $ratio;
                        }
                    } elseif (isset($parameters['height'])) {
                        $height = $parameters['height'];

                        if (isset($medium->image_width, $medium->image_height) && $medium->image_height > 0) {
                            $ratio = $height / $medium->image_height;
                            $width = $medium->image_width * $ratio;
                        }
                    } else {
                        $width = $medium->image_width;
                        $height = $medium->image_height;
                    }

                    return "<img class=\"{$class}\" src=\"{$medium->url}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$alt}\" loading=\"{$loading}\" />";
                } else {
                    return "<!-- media type not supported -->";
                }
            }

            return "<!-- media not found -->";
        });
    }
}
