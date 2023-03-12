<?php

use App\Support\Shortcode;

Parser::registerShortcode('media-url', function (array $parameters = []) {
    if (isset($parameters['id'])) {
        $medium = site()->medium($parameters['id']);
    } elseif (isset($parameters['title'])) {
        $medium = site()->media()->byTitle($parameters['title'])->first();
    }

    return isset($medium)
        ? $medium->url
        : "";
});
