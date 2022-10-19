<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable;

    protected $fillable = [
        'parent_id',
        'target_id',
        'target_type',
        'target',
        'href',
        'title',
        'rank',
        'metadata',
    ];

    protected $casts = [
        'rank' => 'integer',
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
            $builder
                ->orderBy('rank')
                ->orderBy('created_at');
        });

        /**
         * When creating a new menu item, if the target is specified, set the href and title based on the target
         * unless they have already been set.
         */
        static::creating(function ($item) {
            if (isset($item->target)) {
                $item->href ??= $item->target->url;
                $item->title ??= $item->target->title;
            }

            if (! isset($item->rank)) {
                if (isset($item->menu)) {
                    if ($lastMenuItem = $item->menu->items->last()) {
                        $item->rank = $lastMenuItem + 1;
                    }
                }
            }
        });

        /**
         * When a menu item has been deleted, we need to delete all the children as well.
         */
        static::deleted(function ($item) {
            $item->children()->delete();
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeRoot(Builder $query)
    {
        return $query->whereNull('parent_id');
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

    public function rankUp()
    {

    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getSiblingsAttribute()
    {
        if (isset($this->menu)) {
            return $this->menu->items;
        }
    }

    public function getNextItemAttribute()
    {
        if (isset($this->siblings, $this->rank)) {
            return $this->siblings->where('rank', '>', $this->rank)->first();
        }
    }

    public function getPreviousItemAttribute()
    {
        if (isset($this->siblings, $this->rank)) {
            return $this->siblings->where('rank', '<', $this->rank)->last();
        }
    }

    public function getParentOptionsAttribute()
    {
        return $this->exists() && isset($this->menu)
            ? $this->menu->items()->whereNotIn('id', $this->children->pluck('id')->push($this->id))->get()
            : collect();
    }

    public function getTargetOptionsAttribute()
    {
        $optgroups = [];

        foreach (EntryType::all() as $entryType) {
            $optgroups["{$entryType}"] = $entryType->entries;
        }

        foreach (TaxonomyType::all() as $taxonomyType) {
            $optgroups["{$taxonomyType}"] = $taxonomyType->taxonomies;
        }

        return $optgroups;
    }

    public function setTargetAttribute($value)
    {
        $this->target()->dissociate();

        if (str_contains($value, ':')) {
            list($targetType, $targetId) = explode(':', $value, 2);

            if (class_exists($targetType) && is_subclass_of($targetType, Model::class)) {
                if ($target = $targetType::find($targetId)) {
                    $this->target()->associate($target);
                }
            }
        }
    }

    public function getDiffersFromTargetAttribute()
    {
        return isset($this->target)
            && ( $this->target->url !== $this->href || $this->target->title !== $this->title );
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function target()
    {
        return $this->morphTo();
    }
}
