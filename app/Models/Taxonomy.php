<?php

namespace App\Models;

use App\Traits\Cancellable;
use App\Traits\MenuItemable;
use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Taxonomy extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable,
        Cancellable,
        MenuItemable;

    const ICON = 'fa-tags';

    protected $fillable = [
        'name',
        'title',
        'description',
        'cover_file',
        'locale_id',
        'parent_id',
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

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('title');
        });

        static::saving(function ($taxonomy) {
            $taxonomy->name ??= Str::slug($taxonomy->title);
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByName(Builder $query, $name)
    {
        return is_iterable($name)
            ? $query->whereIn('name', $name)
            : $query->where('name', $name);
    }

    public function scopeByType(Builder $query, $taxonomyType)
    {
        return $query->whereIn('type_id', prepareValueForScope($taxonomyType, TaxonomyType::class));
    }

    public function scopeTopLevel(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeByLocale(Builder $query, $locale)
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public function scopeFilter(Builder $query, $filters)
    {
        if (isset($filters['locale_id'])) {
            $query->byLocale($filters['locale_id']);
        }

        return $query;
    }

    public function scopeSearch(Builder $query, $term)
    {
        return $query
            ->where('title', 'LIKE', "%{$term}%")
            ->orWhere('name', 'LIKE', "%{$term}%");
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString()
    {
        return "{$this->title}";
    }

    public function getUrl($absolute = true)
    {
        if ($this->exists()) {
            if (isset($this->locale) && ! $this->locale->is_default) {
                return route('locale.taxonomy', [
                    'locale' => $this->locale->name,
                    'taxonomyType' => $this->type,
                    'taxonomy' => $this,
                ], $absolute);
            } else {
                return route('taxonomy', [
                    'taxonomyType' => $this->type,
                    'taxonomy' => $this,
                ], $absolute);
            }
        }
    }

    public function getAllChildren()
    {
        $children = collect();

        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->children);
        }

        return $children;
    }

    public function getParentOptions()
    {
        $allChildren = $this->getAllChildren();
        $allChildrenIds = $allChildren->pluck('id');

        return static::byType($this->type)
            ->where('id', '!=', $this->id)
            ->whereNotIn('id', $allChildrenIds)
            ->get();
    }

    public function view()
    {
        $views = [
            "{$this->locale->name}.{$this->type->name}.{$this->name}",
            "{$this->locale->name}.{$this->type->name}.default",
            "{$this->locale->name}.{$this->type->name}",
            "{$this->type->name}.{$this->name}",
            "{$this->type->name}.default",
            "{$this->type->name}",
            "taxonomy.{$this->name}",
            "taxonomy.default",
            "taxonomy",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getUrlAttribute()
    {
        return $this->getUrl(true);
    }

    public function getAbsoluteUrlAttribute()
    {
        return $this->getUrl(true);
    }

    public function getRelativeUrlAttribute()
    {
        return $this->getUrl(false);
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function type()
    {
        return $this->belongsTo(TaxonomyType::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function parent()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function children()
    {
        return $this->hasMany(Taxonomy::class, 'parent_id');
    }

    public function entries()
    {
        return $this->belongsToMany(Entry::class);
    }
}
