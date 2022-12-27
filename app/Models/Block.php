<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory,
        SoftDeletes;

    const ICON = 'fa-cube';

    protected $fillable = [
        'location',
        'locale_id',
        'content',
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
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function scopeByLocale(Builder $query, mixed $locale): Builder
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
        return "{$this->content}";
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
}
