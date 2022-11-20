<?php

function seed(array $data, string $class, string $keyColumn = 'name'): array
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
