<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Locale;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Theme
{
    protected static $instance;

    public $name;
    public $package;
    public $vendor;
    public $project;
    public $version;
    public $settings;

    public static function getInstance(string $name = null): self
    {
        return static::$instance ??= new static($name);
    }

    public function __construct(string $name = null)
    {
        $this->name = $name ?? config('site.theme');

        $nameParts = explode(':', $this->name, 2);
        $this->package = $nameParts[0] ?? null;
        $this->version = $nameParts[1] ?? null;

        $packageParts = explode('/', $this->package, 2);
        $this->vendor = $packageParts[0] ?? null;
        $this->project = $packageParts[1] ?? null;
    }

    public function boot(): void
    {
        $viewPaths = config('view.paths');
        $viewPaths[] = $this->path("resources/views");
        config(['view.paths' => array_unique($viewPaths)]);
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function vendor(): ?string
    {
        return $this->vendor;
    }

    public function project(): ?string
    {
        return $this->project;
    }

    public function package(): ?string
    {
        return $this->package;
    }

    public function version(): ?string
    {
        return $this->version;
    }

    public function path(string $path = ''): string
    {
        return !empty($path)
            ? base_path("vendor/{$this->package}/{$path}")
            : base_path("vendor/{$this->package}");
    }

    public function public_path(string $path = ''): string
    {
        return !empty($path)
            ? public_path("themes/{$this->project}/{$path}")
            : public_path("themes/{$this->project}");
    }

    public function asset(string $path, bool $secure = null, string|int $version = null): string
    {
        $version ??= $this->info('version');

        $path = asset("themes/{$this->project}/{$path}", $secure);

        return isset($version)
            ? "{$path}?v={$version}"
            : $path;
    }

    public function info(string $attribute = null): mixed
    {
        $path = $this->path('theme.json');

        if (file_exists($path) && is_readable($path)) {
            $json = file_get_contents($path);
            $info = json_decode($json);

            return isset($attribute)
                ? ( $info->$attribute ?? null )
                : $info;
        }

        return null;
    }

    public function config(string $attribute = null): mixed
    {
        if ($config = $this->info('config')) {
            return isset($attribute)
                ? ( $config->$attribute ?? null )
                : $config;
        }

        return null;
    }

    public function menuLocations(): array
    {
        return $this->info('menuLocations') ?? [];
    }

    public function install(): array
    {
        if (! isset($this->name)) {
            throw new \Exception("No theme name");
        }

        return [
            run("composer require {$this->name} --no-interaction --update-no-dev --prefer-dist --optimize-autoloader"),
            $this->createSymlink(),
            $this->createMenus(),
        ];
    }

    public function update(): array
    {
        if (! isset($this->name)) {
            throw new \Exception("No theme name");
        }

        return [
            run("composer update {$this->name} --no-interaction --no-dev --prefer-dist --optimize-autoloader"),
            $this->createSymlink(),
            $this->createMenus(),
        ];
    }

    public function createSymlink(): bool
    {
        $target = $this->path('public');
        $link = $this->public_path();

        if (is_link($link)) unlink($link);

        return symlink($target, $link);
    }

    public function createMenus(): bool
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

    public function loadSettings(): void
    {
        $settings = $this->info('settings') ?? [];

        foreach ($settings as &$setting) {
            $value = Setting::get($setting->name);

            if (isset($setting->type)) {
                switch ($setting->type) {
                    case 'file':
                        $value = Storage::url($value);
                        break;
                }
            }

            $setting->value = $value;
        }

        $this->settings = collect($settings);
    }

    public function settings(): Collection
    {
        if (! isset($this->settings)) {
            $this->loadSettings();
        }

        return $this->settings;
    }

    public function setting($name): mixed
    {
        if ($setting = $this->settings()->where('name', $name)->first()) {
            return $setting->value;
        }

        return null;
    }
}
