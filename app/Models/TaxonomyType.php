<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxonomyType extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'singular_title',
        'plural_title',
        'icon_class',
    ];

    /**
     * Helpers
     */

    public function __toString(): string
    {
        return "{$this->plural_title}";
    }

    /**
     * Relationships
     */

    public function taxonomies(): HasMany
    {
        return $this->hasMany(Taxonomy::class, 'type_id');
    }
}
