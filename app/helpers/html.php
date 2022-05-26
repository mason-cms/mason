<?php

function htmlInputDatetime($datetime)
{
    if (isset($datetime) && $datetime instanceof \Carbon\Carbon) {
        return $datetime->format('Y-m-d\TH:i:s');
    }
}
