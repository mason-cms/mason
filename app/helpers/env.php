<?php

function writeEnv(array $data = [], bool $forceQuote = false, string $path = null): array
{
    $path ??= base_path('.env');

    if (! file_exists($path)) {
        throw new \Exception("'{$path}' does not exist");
    }

    if (! is_writable($path)) {
        throw new \Exception("'{$path}' is not writable");
    }

    $updated = [];

    foreach ($data as $key => $value) {
        if (is_bool($value)) {
            $value = $value ? "true" : "false";
        } else {
            $hasQuotes = str_starts_with($value, '"') && str_ends_with($value, '"');

            if (! $hasQuotes) {
                $needQuotes = strlen($value) > 0 && str_contains($value, " ");

                if ($forceQuote || $needQuotes) {
                    $value = "\"{$value}\"";
                }
            }
        }

        $oldContents = file_get_contents($path);

        if ($oldContents === false) {
            throw new \Exception("Cannot get content from '{$path}'");
        }

        $oldValue = env($key);

        if (is_bool($oldValue)) {
            $oldValue = $oldValue ? "true" : "false";
        }

        $oldLine = "{$key}={$oldValue}";

        if (! str_contains($oldContents, $oldLine)) {
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

    return $updated;
}
