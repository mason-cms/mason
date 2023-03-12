<?php

use App\Facades\Parser;

Parser::registerShortcode('thumbnail', function (array $parameters = []) {
    if (isset($parameters['id'])) {
        $medium = site()->medium($parameters['id']);
    } elseif (isset($parameters['title'])) {
        $medium = site()->media()->byTitle($parameters['title'])->first();
    }

    if (isset($medium, $medium->url, $medium->preview_url)) {
        $linkClass = $parameters['link-class'] ?? null;
        $linkTarget = $parameters['link-target'] ?? '_self';
        $imgClass = $parameters['img-class'] ?? null;
        $width = $parameters['width'] ?? null;
        $height = $parameters['img-height'] ?? null;
        $alt = $parameters['alt'] ?? null;
        $loading = $parameters['loading'] ?? 'lazy';

        $img = "<img class=\"{$imgClass}\" src=\"{$medium->preview_url}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$alt}\" loading=\"{$loading}\" />";

        return "<a class=\"{$linkClass}\" href=\"{$medium->url}\" target=\"{$linkTarget}\">{$img}</a>";
    }

    return "<!-- media not found -->";
});
