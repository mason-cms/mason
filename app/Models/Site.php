<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $name;
    protected $description;
    protected $theme;

    public function __construct()
    {
        parent::__construct();

        $this->name = config('site.name');
        $this->description = config('site.description');
        $this->theme = theme(config('site.theme'));
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

    public function entries($type = null, $locale = null)
    {
        $query = Entry::query();

        if (isset($type)) {
            $query->byType($type);
        }

        if (isset($locale)) {
            $query->byLocale($locale);
        }

        return $query;
    }

    public function entry($name, $locale = null, $type = null)
    {
        return $this->entries($type, $locale)->byName($name)->first();
    }

    public function taxonomies($type = null, $locale = null)
    {
        $query = Taxonomy::query();

        if (isset($type)) {
            $query->byType($type);
        }

        if (isset($locale)) {
            $query->byLocale($locale);
        }

        return $query;
    }

    public function taxonomy($name, $locale = null, $type = null)
    {
        return $this->taxonomies($type, $locale)->byName($name)->first();
    }

    public function locales()
    {
        return Locale::query();
    }

    public function defaultLocale()
    {
        return Locale::default();
    }

    public function menus($locale = null)
    {
        $query = Menu::query();

        if (isset($locale)) {
            $query->byLocale($locale);
        }

        return $query;
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
