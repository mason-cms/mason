<?php

function htmlInputDatetime(?\Illuminate\Support\Carbon $datetime)
{
    if (isset($datetime)) {
        return $datetime->format('Y-m-d\TH:i:s');
    }

    return null;
}

function htmlLink(string $url, string $text = null): string
{
    $text ??= $url;

    return "<a href=\"{$url}\">{$text}</a>";
}
