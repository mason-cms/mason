<?php

function prepareValueForScope(mixed $value, string $class): array
{
    $values = [];

    if (is_numeric($value)) {
        $values[] = $value;
    } elseif (is_string($value)) {
        if ($value = $class::where('name', $value)->first()) {
            $values[] = $value->id;
        }
    } elseif (is_array($value)) {
        foreach ($value as $v) {
            if (is_numeric($v)) {
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
