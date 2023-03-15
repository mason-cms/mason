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
    public $branch;
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
        $this->branch = $nameParts[1] ?? 'master';

        $packageParts = explode('/', $this->package, 2);
        $this->vendor = $packageParts[0] ?? null;
        $this->project = $packageParts[1] ?? null;
    }

    public function boot(): void
    {
        $viewPaths = config('view.paths');
        $viewPaths[] = $this->path("resources/views");
        config(['view.paths' => array_unique($viewPaths)]);

        if (file_exists($bootFile = $this->path('boot.php'))) {
            require_once $bootFile;
        }
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

    public function branch(): ?string
    {
        return $this->branch;
    }

    public function repository()
    {
        return isset($this->package)
            ? "https://github.com/{$this->package}"
            : null;
    }

    public function path(string $path = ''): string
    {
        $dir = "themes/{$this->package}";

        return !empty($path)
            ? base_path("{$dir}/{$path}")
            : base_path("{$dir}");
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

    public function menuLocations(): Collection
    {
        return collect($this->info('menuLocations') ?? []);
    }

    public function blockLocations(): Collection
    {
        return collect($this->info('blockLocations') ?? []);
    }

    public function blockLocation(string $name): object
    {
        return $this->blockLocations()->where('name', $name)->first();
    }

    public function install(): void
    {
        if (! isset($this->name)) {
            throw new \Exception("No theme name");
        }

        if (! $repository = $this->repository()) {
            throw new \Exception("No theme repository defined.");
        }

        if (! $path = $this->path()) {
            throw new \Exception("No theme path defined.");
        }

        if (is_dir($path)) {
            throw new \Exception("Theme is already installed at {$path}.");
        }

        if (! $branch = $this->branch()) {
            throw new \Exception("No theme branch defined.");
        }

        run(implode("; ", [
            "git clone {$repository} {$path}",
            "cd {$path}",
            "git checkout {$branch}",
            "git pull",
        ]));

        $this->createSymlink();
        $this->createMenus();
    }

    public function update(): void
    {
        if (! isset($this->name)) {
            throw new \Exception("No theme name");
        }

        if (! $path = $this->path()) {
            throw new \Exception("No theme path defined.");
        }

        if (! is_dir($path)) {
            throw new \Exception("Theme has not been installed yet.");
        }

        if (! $branch = $this->branch()) {
            throw new \Exception("No theme branch defined.");
        }

        $datetime = date('YmdGis');

        run(implode("; ", [
            "cd {$path}",
            "git fetch --all",
            "git branch backup-{$datetime}",
            "git checkout {$branch}",
            "git pull",
        ]));

        $this->createSymlink();
        $this->createMenus();
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
                        $value = isset($value) ? Storage::url($value) : null;
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
