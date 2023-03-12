<?php

use App\Facades\Parser;

Parser::registerShortcode('media', function (array $parameters = []) {
    if (isset($parameters['id'])) {
        $medium = site()->medium($parameters['id']);
    } elseif (isset($parameters['title'])) {
        $medium = site()->media()->byTitle($parameters['title'])->first();
    }

    if (isset($medium)) {
        if ($medium->is_image) {
            $class = $parameters['class'] ?? null;
            $alt = $parameters['alt'] ?? null;
            $loading = $parameters['loading'] ?? 'lazy';

            if (isset($parameters['width'], $parameters['height'])) {
                $width = $parameters['width'];
                $height = $parameters['height'];
            } elseif (isset($parameters['width'])) {
                $width = $parameters['width'];

                if (isset($medium->image_width, $medium->image_height) && $medium->image_width > 0) {
                    $ratio = $width / $medium->image_width;
                    $height = round($medium->image_height * $ratio);
                }
            } elseif (isset($parameters['height'])) {
                $height = $parameters['height'];

                if (isset($medium->image_width, $medium->image_height) && $medium->image_height > 0) {
                    $ratio = $height / $medium->image_height;
                    $width = round($medium->image_width * $ratio);
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
