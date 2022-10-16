<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $attributes = [
        'is_default' => false,
    ];

    protected $fillable = [
        'title',
        'is_default',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Static Methods
     */

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    public static function default()
    {
        return static::where('is_default', true)->first()
            ?? static::findByName(config('app.locale'));
    }

    public static function isDefault($locale)
    {
        if (is_string($locale)) {
            $locale = static::findByName($locale);
        }

        return $locale instanceof static && $locale->is_default;
    }

    /**
     * Helpers
     */

    public function __toString()
    {
        return "{$this->title}";
    }

    public function home()
    {
        return $this->is_default
            ? route('home')
            : route('locale.home', [$this]);
    }

    /**
     * Accessors & Mutators
     */

    public function getLanguageAttribute()
    {
        return explode('-', $this->name)[0] ?? null;
    }

    public function getRegionAttribute()
    {
        return explode('-', $this->name)[1] ?? null;
    }

    public function getSystemNameAttribute()
    {
        return str_replace('-', '_', $this->name);
    }

    /**
     * Relationships
     */

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function taxonomies()
    {
        return $this->hasMany(Taxonomy::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
