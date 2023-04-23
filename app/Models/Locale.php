<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder
                ->orderBy('is_default', 'desc')
                ->orderBy('title');
        });

        static::saved(function (Locale $locale) {
            if ($locale->is_default) {
                foreach (Locale::default()->not($locale)->get() as $l) {
                    $l->update(['is_default' => false]);
                }
            }
        });
    }

    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    public static function getDefault(): ?self
    {
        return static::default()->first()
            ?? static::findByName(config('app.locale'));
    }

    public static function isDefault($locale): bool
    {
        if (is_string($locale)) {
            $locale = static::findByName($locale);
        }

        return $locale instanceof static && $locale->is_default;
    }

    public static function exists(Locale|string $locale): bool
    {
        if (is_string($locale)) {
            $locale = static::findByName($locale);
        }

        return $locale instanceof static && $locale->getKey();
    }

    /**
     * Scopes
     */

    public function scopeDefault(Builder $query, bool $isDefault = true): Builder
    {
        return $query->where('is_default', $isDefault);
    }

    public function scopeNot(Builder $query, Locale $locale): Builder
    {
        return $query->where($locale->getKeyName(), '!=', $locale->getKey());
    }

    /**
     * Helpers
     */

    public function __toString(): string
    {
        return "{$this->title}";
    }

    public function path(): string
    {
        return $this->is_default
            ? route('home')
            : route('locale.home', ['locale' => $this->name]);
    }

    /**
     * Accessors & Mutators
     */

    public function getLanguageAttribute(): ?string
    {
        return explode('-', $this->name)[0] ?? null;
    }

    public function getRegionAttribute(): ?string
    {
        return explode('-', $this->name)[1] ?? null;
    }

    public function getSystemNameAttribute(): string
    {
        return str_replace('-', '_', $this->name);
    }

    /**
     * Relationships
     */

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function taxonomies(): HasMany
    {
        return $this->hasMany(Taxonomy::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
