<?php

function seed(array $data, string $class, $keyColumn = 'name')
{
    $created = 0;
    $updated = 0;
    $skipped = 0;
    $errors = 0;

    foreach ($data as $key => $attributes) {
        if ($record = $class::where($keyColumn, $key)->first()) {
            $record->fill($attributes);

            if ($record->isDirty()) {
                if ($record->save()) {
                    $updated++;
                } else {
                    $errors++;
                }
            } else {
                $skipped++;
            }
        } else {
            $record = new $class;
            $record->$keyColumn = $key;
            $record->fill($attributes);

            if ($record->save()) {
                $created++;
            } else {
                $errors++;
            }
        }
    }

    return compact('created', 'updated', 'skipped', 'errors');
}

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
