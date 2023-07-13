<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Site
{
    protected static $instance;

    public $booted = false;
    public $name;
    public $description;
    public $theme;
    public $locale;
    public $lang;

    public static function getInstance(bool $boot = true): self
    {
        return self::$instance ??= new self($boot);
    }

    public function __construct(bool $boot = true)
    {
        $this->name = config('site.name');
        $this->description = config('site.description');
        $this->theme = theme(config('site.theme'));

        if (! $this->booted && $boot) {
            $this->boot();
        }
    }

    public function boot(): void
    {
        if ($defaultLocale = Locale::getDefault()) {
            $this->setLocale($defaultLocale);
        }

        $this->loadLang();

        $this->booted = true;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function theme(): ?Theme
    {
        return $this->theme;
    }

    public function locale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(Locale|string $locale): void
    {
        if (is_string($locale)) {
            $locale = Locale::findByName($locale);
        }

        if ($locale instanceof Locale) {
            $this->locale = $locale;

            setlocale(LC_TIME, $locale->system_name);
            setlocale(LC_MONETARY, $locale->system_name);

            App::setLocale($locale->system_name);

            if (! $locale->is_default) {
                URL::defaults(['locale' => $locale->name]);
            }

            Carbon::setLocale($locale->system_name);
        }
    }

    public function locales(): Builder
    {
        return Locale::query();
    }

    public function alternateLocales(): Builder
    {
        return $this->locales()->where('id', '!=', $this->locale->getKey());
    }

    public function path(Locale $locale = null): ?string
    {
        $locale ??= $this->locale;
        return $locale?->path();
    }

    public function langPath(): ?string
    {
        return isset($this->theme)
            ? $this->theme->path("resources/lang/{$this->locale->system_name}")
            : null;
    }

    public function loadLang(): void
    {
        $lang = [];

        if ($langPath = $this->langPath()) {
            foreach (glob("{$langPath}/*.php") as $langFile) {
                $filename = pathinfo($langFile)['filename'];
                $lang[$filename] = include $langFile;
            }
        }

        $this->lang = Arr::dot($lang);
    }

    public function lang(): array
    {
        return $this->lang;
    }

    public function trans(string $key, array $replace = []): ?string
    {
        $text = $this->lang[$key] ?? $key;

        foreach ($replace as $k => $v) {
            $text = str_replace(":{$k}", $v, $text);
        }

        return $text;
    }

    public function entries(mixed $type = null, mixed $locale = null, string $status = Entry::STATUS_PUBLISHED): Builder
    {
        $query = Entry::byLocale($locale ?? $this->locale);

        if (isset($type)) {
            $query->byType($type);
        }

        if (isset($status)) {
            $query->byStatus($status);
        }

        return $query;
    }

    public function entry(string $name, mixed $locale = null, mixed $type = null): ?Entry
    {
        return $this->entries(type: $type, locale: $locale)
            ->byName($name)
            ->first();
    }

    public function home(mixed $locale = null, mixed $type = null): ?Entry
    {
        return $this->entries(type: $type, locale: $locale)
            ->home()
            ->first();
    }

    public function homePage(mixed $locale = null): ?Entry
    {
        return $this->home(locale: $locale, type: 'page');
    }

    public function entryTypes(): Builder
    {
        $query = EntryType::query();

        return $query;
    }

    public function entryType(string $name): ?EntryType
    {
        return $this->entryTypes()
            ->byName($name)
            ->first();
    }

    public function taxonomyTypes(): Builder
    {
        $query = TaxonomyType::query();

        return $query;
    }

    public function taxonomyType(string $name): ?TaxonomyType
    {
        return $this->taxonomyTypes()
            ->byName($name)
            ->first();
    }

    public function taxonomies(mixed $type = null, mixed $locale = null): Builder
    {
        $query = Taxonomy::byLocale($locale ?? $this->locale);

        if (isset($type)) {
            $query->byType($type);
        }

        return $query;
    }

    public function taxonomy(string $name, mixed $locale = null, mixed $type = null): ?Taxonomy
    {
        return $this->taxonomies(type: $type, locale: $locale)
            ->byName($name)
            ->first();
    }

    public function defaultLocale(): ?Locale
    {
        return Locale::getDefault();
    }

    public function menus(mixed $locale = null): Builder
    {
        return Menu::byLocale($locale ?? $this->locale);
    }

    public function menu(string $location, mixed $locale = null): ?Menu
    {
        return Menu::byLocation($location)
            ->byLocale($locale ?? $this->locale)
            ->first();
    }

    public function media(): Builder
    {
        return Medium::query();
    }

    public function medium(int $id): ?Medium
    {
        return $this->media()->find($id);
    }

    public function blocks(string $location = null, mixed $locale = null): Builder
    {
        $query = Block::query();

        if (isset($location)) {
            $query->byLocation($location);
        }

        if ($locale ??= $this->locale) {
            $query->byLocale($locale);
        }

        return $query;
    }

    public function users(): Builder
    {
        return User::query();
    }

    public function storageUrl(string $path): string
    {
        return Storage::url($path);
    }
}
