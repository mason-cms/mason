<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, Metable;

    const ICON = 'fa-list-dropdown';

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

    protected static function boot()
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

    public static function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }

    public static function scopeByLocale($query, $locale)
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString()
    {
        return $this->render();
    }

    public function view()
    {
        $views = [
            "{$this->locale->name}.menu.{$this->location}.{$this->name}",
            "{$this->locale->name}.menu.{$this->name}",
            "{$this->locale->name}.menu.{$this->location}.default",
            "{$this->locale->name}.menu.{$this->location}",
            "{$this->locale->name}.menu.default",
            "{$this->locale->name}.menu",
            "menu.{$this->name}",
            "menu.default",
            "menu",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }
    }

    public function render(array $data = [])
    {
        return view($this->view(), array_merge($data, ['menu' => $this]))->render();
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getLocationTitleAttribute()
    {
        if (isset($this->location)) {
            foreach (site()->theme()->menuLocations() as $menuLocation) {
                if ($menuLocation->name === $this->location) {
                    return $menuLocation->title;
                }
            }
        }
    }

    public function getRootItemsAttribute()
    {
        return $this->items()->root()->get();
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
