<?php

function site($boot = true)
{
    return \App\Models\Site::getInstance($boot);
}

function theme($name = null)
{
    return \App\Models\Theme::getInstance($name);
}

function i($class, $style = 'fa-solid')
{
    return "<i class=\"{$style} {$class}\"></i>";
}

function icon($iClass, $sClass = '', $iStyle = 'fa-solid')
{
    $i = i($iClass, $iStyle);
    return "<span class=\"icon {$sClass}\">{$i}</span>";
}
