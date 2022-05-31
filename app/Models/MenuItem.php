<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes, Metable;

    protected $fillable = [
        'parent_id',
        'target_id',
        'target_type',
        'target',
        'href',
        'title',
        'metadata',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Static Methods
     */

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($item) {
            $item->children()->delete();
        });
    }

    /**
     * Scopes
     */

    public function scopeTop($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Helpers
     */

    public function __toString()
    {
        $str = $this->title ?? $this->target;
        return "{$str}";
    }

    /**
     * Accessors & Mutators
     */

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

    /**
     * Relationships
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
