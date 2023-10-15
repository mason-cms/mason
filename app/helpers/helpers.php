<?php

function site(bool $boot = true): \App\Models\Site
{
    return \App\Models\Site::getInstance($boot);
}

function theme(string $name = null): \App\Models\Theme
{
    return \App\Models\Theme::getInstance($name);
}

function storageUrl(string $path): ?string
{
    return \Illuminate\Support\Facades\Storage::url($path);
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

function run(string $command): ?string
{
    if (! function_exists('exec')) {
        throw new \Exception("Function 'shell_exec' is not available. Please enable it in your php.ini.");
    }

    exec($command, $output, $resultCode);

    if ($resultCode !== 0) {
        throw new \Exception(sprintf("Could not run command: %s. Error code: %s. Output: %s.", $command, $resultCode, var_export($output, true)));
    }

    return is_array($output)
        ? implode(PHP_EOL, $output)
        : $output;
}

function is_email(mixed $value): bool
{
    return isset($value)
        && is_string($value)
        && strlen($value) > 0
        && filter_var($value, FILTER_VALIDATE_EMAIL);
}
