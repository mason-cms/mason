<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Entry extends Model
{
    use HasFactory, SoftDeletes, Metable;

    const ICON = 'fa-file';

    protected $fillable = [
        'name',
        'locale_id',
        'title',
        'body',
        'author_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder
                ->orderBy('published_at', 'desc')
                ->orderBy('created_at', 'desc');
        });
    }

    public static function scopeByType($query, $entryType)
    {
        if (is_string($entryType)) {
            $entryType = EntryType::where('name', $entryType)->first();
        }

        if ($entryType instanceof EntryType) {
            return $query->where('type_id', $entryType->id);
        }
    }

    public static function scopeByLocale($query, $locale)
    {
        if (is_string($locale)) {
            $locale = Locale::where('name', $locale)->first();
        }

        if ($locale instanceof Locale) {
            return $query->where('locale_id', $locale->id);
        }
    }

    public static function scopeSearch($query, $term)
    {
        return $query
            ->where('title', 'LIKE', "%{$term}%")
            ->orWhere('body', 'LIKE', "%{$term}%");
    }

    public function __toString()
    {
        return "{$this->title}";
    }

    public function type()
    {
        return $this->belongsTo(EntryType::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->body, 150);
    }

    public function getStatusAttribute()
    {
        if (isset($this->published_at)) {
            if ($this->published_at <= now()) {
                return 'published';
            } else {
                return 'scheduled';
            }
        } else {
            return 'draft';
        }
    }

    public function getUrl($absolute = true)
    {
        $defaultLocale = Setting::get('site_default_locale');

        if (isset($this->locale) && $this->locale->name !== $defaultLocale) {
            return route('entry', ['locale' => $this->locale->name, 'entry' => $this], $absolute);
        } else {
            return route('entry', ['entry' => $this], $absolute);
        }
    }

    public function getUrlAttribute()
    {
        return $this->getUrl(true);
    }

    public function getAbsoluteUrlAttribute()
    {
        return $this->getUrl(true);
    }

    public function getRelativeUrlAttribute()
    {
        return $this->getUrl(false);
    }
}
