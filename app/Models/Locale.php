<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'name',
        'title',
        'is_default',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_default' => 'boolean',
    ];

    /**
     * Static Methods
     */

    protected static function boot()
    {
        parent::boot();

        static::saved(function (Locale $locale) {
            if ($locale->is_default) {
                foreach (Locale::default()->not($locale)->get() as $l) {
                    $l->update(['is_default' => false]);
                }
            }
        });
    }

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    public static function getDefault()
    {
        return static::default()->first()
            ?? static::findByName(config('app.locale'));
    }

    public static function isDefault($locale)
    {
        if (is_string($locale)) {
            $locale = static::findByName($locale);
        }

        return $locale instanceof static && $locale->is_default;
    }

    public static function exists($locale)
    {
        if (is_string($locale)) {
            $locale = static::findByName($locale);
        }

        return $locale instanceof static && $locale->exists();
    }

    /**
     * Scopes
     */

    public function scopeDefault(Builder $query, bool $isDefault = true)
    {
        return $query->where('is_default', $isDefault);
    }

    public function scopeNot(Builder $query, Locale $locale)
    {
        return $query->where($locale->getKeyName(), '!=', $locale->getKey());
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
