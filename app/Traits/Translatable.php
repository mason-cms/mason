<?php

namespace App\Traits;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Translatable
{
    protected static function bootTranslatable(): void
    {
        static::saving(function (self $instance) {
            // prevent having the original instance referencing itself (infinite loop)
            if (isset($instance->original_instance) && $instance->original_instance->is($instance)) {
                $instance->original_instance()->disassociate();
            }

            // clear original entry if entry locale is the default
            if (isset($instance->locale) && $instance->locale->is_default) {
                $instance->original_instance()->disassociate();
            }
        });
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public function scopeOriginals(Builder $query): Builder
    {
        $defaultLocale = Locale::getDefault();

        if (! isset($defaultLocale)) {
            throw new \Exception("No default locale defined");
        }

        return $query->byLocale($defaultLocale);
    }

    public function original_instance(): BelongsTo
    {
        return $this->belongsTo(self::class, 'original_id');
    }

    public function translations(): Builder
    {
        $query = self::query();

        if (! $this->exists) {
            throw new \Exception("Cannot fetch translations on unsaved instance");
        }

        $defaultLocale = Locale::getDefault();

        if (! isset($defaultLocale)) {
            throw new \Exception("No default locale defined");
        }

        $original = $this->original_instance;

        if (isset($original)) {
            // current item is not original, find the original and return it along with the translations (except the current item)
            return $query
                ->where(function (Builder $q) use ($original) {
                    $originalId = $original->getKey();

                    return $q
                        ->where('id', $originalId)
                        ->orWhere('original_id', $originalId);
                })
                ->where('id', '!=', $this->getKey());
        } else {
            // current item is original, return other items which have this one has their original
            return $query->where('original_id', $this->getKey());
        }
    }

    public function getTranslationsAttribute(): Collection
    {
        return $this->translations()->get();
    }

    public function getTranslation(mixed $locale): ?self
    {
        return $this->translations()->byLocale($locale)->first();
    }
}
