<?php

namespace App\Models;

use App\Enums\EditorMode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected static function boot(): void
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

    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByName(Builder $query, string $name): Builder
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

    public function __toString(): string
    {
        return "{$this->plural_title}";
    }

    public function view(): ?string
    {
        $views = [
            "{$this->locale->name}.{$this->name}.entries", // en.post.entries
            "{$this->locale->name}.entries.{$this->name}", // en.entries.post
            "{$this->locale->name}.entries.default", // en.entries.default
            "{$this->locale->name}.entries", // en.entries
            "{$this->name}.entries", // post.entries
            "entries.{$this->name}", // entries.post
            "entries.default", // entries.default
            "entries", // entries
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }

        return null;
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'type_id');
    }
}
