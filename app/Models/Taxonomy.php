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
    use HasFactory, SoftDeletes, Metable, Cancellable, MenuItemable;

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

    public static function scopeByType($query, $taxonomyType)
    {
        return $query->whereIn('type_id', prepareValueForScope($taxonomyType, TaxonomyType::class));
    }

    public static function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public static function scopeByLocale($query, $locale)
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public static function scopeFilter($query, $filters)
    {
        if (isset($filters['locale_id'])) {
            $query->byLocale($filters['locale_id']);
        }

        return $query;
    }

    public static function scopeSearch($query, $term)
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
