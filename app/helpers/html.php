<?php

function htmlInputDatetime(?\Illuminate\Support\Carbon $datetime)
{
    if (isset($datetime)) {
        return $datetime->format('Y-m-d\TH:i:s');
    }

    return null;
}
