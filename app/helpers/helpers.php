<?php

function site(bool $boot = true): \App\Models\Site
{
    return \App\Models\Site::getInstance($boot);
}

function theme(string $name = null): \App\Models\Theme
{
    return \App\Models\Theme::getInstance($name);
}

function i(string $class, string $style = 'fa-solid'): string
{
    return "<i class=\"{$style} {$class}\"></i>";
}

function icon(string $iClass, string $sClass = '', string $iStyle = 'fa-solid'): string
{
    $i = i($iClass, $iStyle);
    return "<span class=\"icon {$sClass}\">{$i}</span>";
}

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

function quote(?string $string): string
{
    return isset($string) && strlen($string) > 0
        ? "\"{$string}\""
        : "";
}

function run(string $command): ?string
{
    if (! function_exists('exec')) {
        throw new \Exception("Function 'shell_exec' is not available. Please enable it in your php.ini.");
    }

    exec($command, $output, $resultCode);

    if ($resultCode !== 0) {
        throw new \Exception(sprintf("Could not run command: %s. Error code: %s. Output: %s.", $command, $resultCode, $output));
    }

    return $output;
}
