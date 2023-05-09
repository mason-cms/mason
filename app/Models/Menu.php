<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable;

    const ICON = 'fa-bars';

    protected $fillable = [
        'location',
        'locale_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * ==================================================
     * Static Methods
     * ==================================================
     */

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($menu) {
            $menu->items()->delete();
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public static function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public static function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', Locale::resolveAll($locale)->pluck('id'));
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString(): string
    {
        return $this->render();
    }

    public function view(): ?string
    {
        $views = [
            "{$this->locale->name}.menu.{$this->location}.default",
            "{$this->locale->name}.menu.{$this->location}",
            "{$this->locale->name}.menu.default",
            "{$this->locale->name}.menu",
            "menu.{$this->location}.default",
            "menu.{$this->location}",
            "menu.default",
            "menu",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }

        return null;
    }

    public function render(array $data = []): ?string
    {
        if ($view = $this->view()) {
            return view($view, array_merge($data, ['menu' => $this]))->render();
        }

        return null;
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getLocationTitleAttribute(): ?string
    {
        if (isset($this->location)) {
            foreach (site(false)->theme()->menuLocations() as $menuLocation) {
                if ($menuLocation->name === $this->location) {
                    return $menuLocation->title;
                }
            }
        }

        return null;
    }

    public function getRootItemsAttribute(): EloquentCollection
    {
        return $this->items()->root()->get();
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
