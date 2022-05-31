<?php

namespace App\Models;

use App\Traits\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory, SoftDeletes, Metable;

    const STORAGE_DIR = 'public/media';
    const DEFAULT_VISIBILITY = 'public';
    const RANDOM_PATH_LENGTH = 8;

    protected $fillable = [
        'title',
        'locale_id',
        'file',
    ];

    /**
     * Scopes
     */

    public static function scopeByLocale($query, $locale)
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    /**
     * Helpers
     */

    public function __toString()
    {
        return "{$this->title}";
    }

    /**
     * Accessors & Mutators
     */

    public function setFileAttribute(File|UploadedFile $file)
    {
        $this->title ??= $file->getClientOriginalName();

        $date = date('Y/m');
        $randomString = Str::random(static::RANDOM_PATH_LENGTH);

        $this->storage_key = Storage::putFileAs(
            static::STORAGE_DIR,
            $file,
            "{$date}/{$randomString}/{$this->title}",
            static::DEFAULT_VISIBILITY
        );
    }

    public function getUrlAttribute()
    {
        if (isset($this->storage_key)) {
            return Storage::url($this->storage_key);
        }
    }

    /**
     * Relationships
     */

    public function parent()
    {
        return $this->morphTo();
    }
}
