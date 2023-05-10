<?php

function setEnv(array $data = [], bool $forceQuote = false): array
{
    $updated = [];

    if (file_exists($path = base_path('.env'))) {
        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? "true" : "false";
            } else {
                $needQuotes = str_contains($value, " ")
                    && ! str_starts_with($value, '"')
                    && ! str_ends_with($value, '"');

                if ($forceQuote || $needQuotes) {
                    $value = quote($value);
                }
            }

            $oldContents = file_get_contents($path);

            $oldValue = env($key);

            if (is_bool($oldValue)) {
                $oldValue = $oldValue ? "true" : "false";
            }

            $oldLine = "{$key}={$oldValue}";

            if (! str_contains($oldContents, $oldLine)) {
                $oldValue = quote($oldValue);
                $oldLine = "{$key}={$oldValue}";
            }

            if (str_contains($oldContents, $oldLine)) {
                $newLine = "{$key}={$value}";
                $newContents = str_replace($oldLine, $newLine, $oldContents);

                if (file_put_contents($path, $newContents) !== false) {
                    $updated[$key] = $value;
                }
            }
        }
    }

    return $updated;
}
