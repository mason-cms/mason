<?php

function prepareValueForScope($value, $class)
{
    $values = [];

    if (is_integer($value)) {
        $values[] = $value;
    } elseif (is_string($value)) {
        if ($value = $class::where('name', $value)->first()) {
            $values[] = $value->id;
        }
    } elseif (is_array($value)) {
        foreach ($value as $v) {
            if (is_integer($v)) {
                $values[] = $v;
            } elseif (is_string($v)) {
                if ($v = $class::where('name', $v)->first()) {
                    $values[] = $v->id;
                }
            } elseif ($v instanceof $class) {
                $values[] = $v->id;
            }
        }
    } elseif ($value instanceof $class) {
        $values[] = $value->id;
    }

    return $values;
}

function htmlInputDatetime($datetime)
{
    if (isset($datetime) && $datetime instanceof \Carbon\Carbon) {
        return $datetime->format('Y-m-d\TH:i:s');
    }
}
