<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Locale;

class Theme
{
    protected static $instance;

    public $name;
    public $package;
    public $vendor;
    public $project;
    public $version;

    public static function getInstance($name = null)
    {
        return static::$instance ??= new static($name);
    }

    public function __construct($name = null)
    {
        $this->name = $name ?? config('site.theme');

        $nameParts = explode(':', $this->name, 2);
        $this->package = $nameParts[0] ?? null;
        $this->version = $nameParts[1] ?? null;

        $packageParts = explode('/', $this->package, 2);
        $this->vendor = $packageParts[0] ?? null;
        $this->project = $packageParts[1] ?? null;
    }

    public function boot()
    {
        $viewPaths = config('view.paths');
        $viewPaths[] = $this->path("resources/views");
        config(['view.paths' => array_unique($viewPaths)]);
    }

    public function name()
    {
        return $this->name;
    }

    public function vendor()
    {
        return $this->vendor;
    }

    public function project()
    {
        return $this->project;
    }

    public function package()
    {
        return $this->package;
    }

    public function version()
    {
        return $this->version;
    }

    public function path($path = '')
    {
        return !empty($path)
            ? base_path("vendor/{$this->package}/{$path}")
            : base_path("vendor/{$this->package}");
    }

    public function public_path($path = '')
    {
        return !empty($path)
            ? public_path("themes/{$this->project}/{$path}")
            : public_path("themes/{$this->project}");
    }

    public function asset($path, $secure = null)
    {
        return asset("themes/{$this->project}/{$path}", $secure);
    }

    public function info($attribute = null)
    {
        $path = $this->path('theme.json');

        if (file_exists($path) && is_readable($path)) {
            $json = file_get_contents($path);
            $info = json_decode($json);

            return isset($attribute) ? ( $info->$attribute ?? null ) : $info;
        }
    }

    public function config($attribute = null)
    {
        if ($config = $this->info('config')) {
            return isset($attribute) ? ( $config->$attribute ?? null ) : $config;
        }
    }

    public function menuLocations()
    {
        return $this->info('menuLocations') ?? [];
    }

    public function install()
    {
        if (isset($this->name)) {
            return [
                shell_exec("composer require {$this->name} --no-interaction --prefer-dist --optimize-autoloader"),
                $this->createSymlink(),
                $this->createMenus(),
            ];
        }

        return false;
    }

    public function update()
    {
        if (isset($this->name)) {
            return [
                shell_exec("composer update {$this->name} --no-interaction --prefer-dist --optimize-autoloader"),
                $this->createSymlink(),
                $this->createMenus(),
            ];
        }

        return false;
    }

    public function createSymlink()
    {
        $target = $this->path('public');
        $link = $this->public_path();

        if (is_link($link)) unlink($link);

        return symlink($target, $link);
    }

    public function createMenus()
    {
        foreach ($this->menuLocations() as $menuLocation) {
            foreach (Locale::all() as $locale) {
                Menu::firstOrCreate([
                    'location' => $menuLocation->name,
                    'locale_id' => $locale->id,
                ]);
            }
        }

        return true;
    }

    public function settings()
    {
        $settings = $this->info('settings') ?? [];

        foreach ($settings as &$setting) {
            $setting->value = Setting::get($setting->name);
        }

        return collect($settings);
    }

    public function setting($key)
    {
        return Setting::get($key);
    }
}
