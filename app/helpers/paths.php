<?php

function theme_path($path = '', $theme = null)
{
    $theme ??= config('site.theme');
    $theme = explode(':', $theme, 2)[0];

    if (isset($theme) && strlen($theme) > 0) {
        return !empty($path)
            ? base_path("vendor/{$theme}/{$path}")
            : base_path("vendor/{$theme}");
    }
}

function theme_public_path($path = '', $theme = null)
{
    $theme ??= config('site.theme');
    $theme = explode(':', $theme, 2)[0];
    $theme = array_reverse(explode('/', $theme))[0];

    if (isset($theme) && strlen($theme) > 0) {
        return !empty($path)
            ? public_path("themes/{$theme}/{$path}")
            : public_path("themes/{$theme}");
    }
}
