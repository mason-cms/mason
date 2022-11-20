<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'value',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Static Methods
     */

    public static function findByName(string $name): ?self
    {
        return static::byName($name)->first();
    }

    /**
     * Scopes
     */

    public static function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    /**
     * Accessors & Mutators
     */

    public function getValueAttribute(): ?string
    {
        return isset($this->attributes['value'])
            ? unserialize($this->attributes['value'])
            : null;
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = isset($value)
            ? serialize($value)
            : null;
    }

    /**
     * Relationships
     */

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }
}
