<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class Site
{
    protected static $instance;

    public $name;
    public $description;
    public $theme;
    public $locale;
    public $lang;

    public static function getInstance($boot = true)
    {
        return static::$instance ??= new static($boot);
    }

    public function __construct($boot = true)
    {
        $this->name = config('site.name');
        $this->description = config('site.description');
        $this->theme = theme(config('site.theme'));

        if ($boot) {
            $this->boot();
        }
    }

    public function boot()
    {
        $this->setLocale(Locale::getDefault());

        $this->loadLang();

        if (isset($this->theme)) {
            $this->theme->boot();
        }
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function theme()
    {
        return $this->theme;
    }

    public function locale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
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

    public function locales()
    {
        return Locale::query();
    }

    public function home($locale = null)
    {
        $locale ??= $this->locale;
        return $locale->home();
    }

    public function langPath()
    {
        return isset($this->theme)
            ? $this->theme->path("resources/lang/{$this->locale->system_name}")
            : null;
    }

    public function loadLang()
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

    public function lang()
    {
        return $this->lang;
    }

    public function trans($key)
    {
        return $this->lang[$key] ?? $key;
    }

    public function entries($type = null, $locale = null)
    {
        $query = Entry::byLocale($locale ?? $this->locale);

        if (isset($type)) {
            $query->byType($type);
        }

        return $query;
    }

    public function entry($name, $locale = null, $type = null)
    {
        return $this->entries($type, $locale ?? $this->locale)
            ->byName($name)
            ->first();
    }

    public function taxonomies($type = null, $locale = null)
    {
        $query = Taxonomy::byLocale($locale ?? $this->locale);

        if (isset($type)) {
            $query->byType($type);
        }

        return $query;
    }

    public function taxonomy($name, $locale = null, $type = null)
    {
        return $this->taxonomies($type, $locale ?? $this->locale)
            ->byName($name)
            ->first();
    }

    public function defaultLocale()
    {
        return Locale::getDefault();
    }

    public function menus($locale = null)
    {
        return Menu::byLocale($locale ?? $this->locale);
    }

    public function menu($location, $locale = null)
    {
        return Menu::byLocation($location)
            ->byLocale($locale ?? $this->locale)
            ->first();
    }

    public function settings()
    {
        return Setting::query();
    }

    public function users()
    {
        return User::query();
    }
}
