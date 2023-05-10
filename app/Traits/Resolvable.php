<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Resolvable
{
    public static function resolve(mixed $value): ?self
    {
        if ($value instanceof self) {
            return $value;
        } elseif (is_string($value) || is_numeric($value)) {
            if (property_exists(self::class, 'resolvable')) {
                $properties = (new self)->resolvable;

                foreach ($properties as $property) {
                    if ($record = self::where($property, $value)->first()) {
                        return $record;
                    }
                }
            }
        }

        return null;
    }

    public static function resolveAll(mixed $values): Collection
    {
        $records = collect();

        if (is_iterable($values)) {
            foreach ($values as $value) {
                if ($record = self::resolve($value)) {
                    $records->push($record);
                }
            }
        } else {
            if ($record = self::resolve($values)) {
                $records->push($record);
            }
        }

        return $records;
    }
}
