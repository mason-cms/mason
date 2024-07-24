<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder
                ->orderBy('rank')
                ->orderBy('created_at');
        });

        static::creating(function (self $item) {
            /**
             * When creating a new menu item, if the target is specified, set the href and title based on the target
             * unless they have already been set.
             */
            if (isset($item->target)) {
                $item->href ??= $item->target->url;
                $item->title ??= $item->target->title;
            }

            if (! isset($item->rank)) {
                if (isset($item->menu)) {
                    if ($lastMenuItem = $item->menu->items->last()) {
                        $item->rank = $lastMenuItem->rank + 1;
                    }
                }
            }
        });

        static::deleted(function (self $item) {
            /**
             * When a menu item has been deleted, we need to delete all the children as well.
             */
            $item->children()->delete();
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString(): string
    {
        return "{$this->title}";
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getSiblingsAttribute(): ?EloquentCollection
    {
        return isset($this->menu)
            ? $this->menu->items
            : null;
    }

    public function getNextItemAttribute(): ?self
    {
        if (isset($this->siblings, $this->rank)) {
            return $this->siblings->where('rank', '>', $this->rank)->first();
        }

        return null;
    }

    public function getPreviousItemAttribute(): ?self
    {
        if (isset($this->siblings, $this->rank)) {
            return $this->siblings->where('rank', '<', $this->rank)->last();
        }

        return null;
    }

    public function getParentOptionsAttribute(): EloquentCollection|Collection
    {
        return $this->exists() && isset($this->menu)
            ? $this->menu->items()->whereNotIn('id', $this->children->pluck('id')->push($this->id))->get()
            : collect();
    }

    public function getTargetOptionsAttribute(): array
    {
        $optgroups = [];

        foreach (EntryType::all() as $entryType) {
            $optgroups["{$entryType}"] = $entryType->entries;
        }

        foreach (TaxonomyType::all() as $taxonomyType) {
            $optgroups["{$taxonomyType}"] = $taxonomyType->taxonomies;
        }

        $optgroups[__('media.title')] = Medium::all();

        return $optgroups;
    }

    public function setTargetAttribute(?string $value): void
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

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}
