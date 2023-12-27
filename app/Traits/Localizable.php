<?php

namespace App\Traits;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Localizable
{
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', Locale::resolveAll($locale)->pluck('id'));
    }
}
