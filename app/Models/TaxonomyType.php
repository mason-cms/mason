<?php

namespace App\Models;

use App\Traits\Resolvable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class TaxonomyType extends Model
{
    use HasFactory,
        SoftDeletes,
        Resolvable;

    protected $resolvable = [
        'id',
        'name',
    ];

    protected $fillable = [
        'name',
        'singular_title',
        'plural_title',
        'icon_class',
    ];

    /**
     * ==================================================
     * Static Methods
     * ==================================================
     */

    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByName(Builder $query, mixed $name): Builder
    {
        return is_iterable($name)
            ? $query->whereIn('name', $name)
            : $query->where('name', $name);
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString(): string
    {
        return "{$this->plural_title}";
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function taxonomies(): HasMany
    {
        return $this->hasMany(Taxonomy::class, 'type_id');
    }
}
