<?php

function theme_path($path = '')
{
    $siteTheme = explode(':', config('site.theme'), 2)[0];
    return base_path("vendor/{$siteTheme}/{$path}");
}

function theme_public_path($path = '')
{
    return public_path("theme/{$path}");
}
