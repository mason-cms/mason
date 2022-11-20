<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Medium extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable;

    const ICON = 'fa-photo-film';

    const STORAGE_PATH = 'media';
    const DEFAULT_VISIBILITY = 'public';

    protected $fillable = [
        'title',
        'locale_id',
        'file',
    ];

    protected $casts = [
        'filesize' => 'integer',
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
                ->orderBy('created_at', 'desc');
        });

        static::creating(function (Medium $media) {
            if (! isset($media->locale)) {
                if (isset($media->parent, $media->parent->locale)) {
                    $media->locale()->associate($media->parent->locale);
                } elseif ($defaultLocale = Locale::getDefault()) {
                    $media->locale()->associate($defaultLocale);
                }
            }
        });

        static::deleted(function (Medium $medium) {
            if (isset($medium->storage_key) && Storage::exists($medium->storage_key)) {
                Storage::delete($medium->storage_key);
            }
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (isset($filters['locale_id'])) {
            $query->byLocale($filters['locale_id']);
        }

        if (isset($filters['author_id'])) {
            $query->byAuthor($filters['author_id']);
        }

        return $query;
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('title', 'LIKE', "%{$term}%");
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString(): string
    {
        return "{$this->title}";
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function setFileAttribute(File|UploadedFile $file): void
    {
        $filename = $originalName = $file->getClientOriginalName();

        while (Storage::exists(static::STORAGE_PATH . '/' . $filename)) {
            $i ??= 2;
            $pathinfo ??= pathinfo($filename);
            $filename = $pathinfo['filename'] . "-{$i}." . $pathinfo['extension'];
            $i++;
        }

        $this->title ??= $originalName;

        $this->content_type = $file->getMimeType();

        $this->filesize = $file->getSize();

        $this->storage_key = Storage::putFileAs(
            static::STORAGE_PATH,
            $file,
            $filename,
            static::DEFAULT_VISIBILITY
        );
    }

    public function getUrlAttribute(): ?string
    {
        return isset($this->storage_key)
            ? Storage::url($this->storage_key)
            : null;
    }

    public function getIsImageAttribute(): bool
    {
        return isset($this->content_type)
            && str_starts_with($this->content_type, 'image/');
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }
}
