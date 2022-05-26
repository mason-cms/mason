<?php

function theme_path($path = '')
{
    $siteTheme = explode(':', config('site.theme'), 2)[0];
    return base_path("vendor/{$siteTheme}/{$path}");
}
