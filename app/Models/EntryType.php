<?php

namespace App\Models;

use App\Enums\EditorMode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryType extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'singular_title',
        'plural_title',
        'icon_class',
        'default_editor_mode',
    ];

    protected $casts = [
        'default_editor_mode' => EditorMode::class,
    ];

    /**
     * ==================================================
     * Static Methods
     * ==================================================
     */

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder
                ->orderBy('plural_title')
                ->orderBy('name');
        });

        static::creating(function (EntryType $entryType) {
            $entryType->default_editor_mode ??= EditorMode::WYSIWYG;
        });
    }

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByName(Builder $query, $name)
    {
        return is_iterable($name)
            ? $query->whereIn('name', $name)
            : $query->where('name', $name);
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString()
    {
        return "{$this->plural_title}";
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function entries()
    {
        return $this->hasMany(Entry::class, 'type_id');
    }
}
