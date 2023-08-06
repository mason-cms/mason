<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasFactory,
        SoftDeletes;

    const ICON = 'fa-clipboard-list';

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query
            ->where('name', 'LIKE', "%{$term}%");
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query;
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }
}
