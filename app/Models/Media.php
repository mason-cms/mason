<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable;

    const STORAGE_DISK = 'public';
    const STORAGE_PATH = 'media';
    const DEFAULT_VISIBILITY = 'public';

    protected $fillable = [
        'title',
        'locale_id',
        'file',
    ];

    /**
     * ==================================================
     * Static Methods
     * ==================================================
     */

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Media $media) {
            if (! isset($media->locale)) {
                if (isset($media->parent, $media->parent->locale)) {
                    $media->locale()->associate($media->parent->locale);
                } elseif ($defaultLocale = Locale::getDefault()) {
                    $media->locale()->associate($defaultLocale);
                }
            }
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByLocale(Builder $query, $locale)
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
        return "{$this->title}";
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function setFileAttribute(File|UploadedFile $file)
    {
        $this->title ??= $file->getClientOriginalName();

        $this->storage_key = Storage::disk(self::STORAGE_DISK)
            ->put(static::STORAGE_PATH, $file, static::DEFAULT_VISIBILITY);
    }

    public function getUrlAttribute()
    {
        if (isset($this->storage_key)) {
            return Storage::url($this->storage_key);
        }
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function parent()
    {
        return $this->morphTo();
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}
