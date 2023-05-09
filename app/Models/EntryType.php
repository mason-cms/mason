<?php

namespace App\Models;

use App\Enums\EditorMode;
use App\Traits\Resolvable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class EntryType extends Model
{
    use HasFactory,
        SoftDeletes,
        Resolvable;

    const ORDER_COLUMNS = [
        'id',
        'name',
        'title',
        'published_at',
        'created_at',
    ];

    const ORDER_DIRECTIONS = [
        'asc',
        'desc',
    ];

    const DEFAULT_ORDER_COLUMN = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    protected $resolvable = [
        'id',
        'name',
    ];

    protected $fillable = [
        'name',
        'singular_title',
        'plural_title',
        'icon_class',
        'default_editor_mode',
        'default_order_column',
        'default_order_direction',
    ];

    protected $casts = [
        'default_editor_mode' => EditorMode::class,
    ];

    protected $attributes = [
        'default_order_column' => self::DEFAULT_ORDER_COLUMN,
        'default_order_direction' => self::DEFAULT_ORDER_DIRECTION,
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

    public function scopeByName(Builder $query, mixed $name): Builder
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
        return $this
            ->hasMany(Entry::class, 'type_id')
            ->orderBy('is_home', 'desc')
            ->orderBy(
                column: $this->default_order_column ?? self::DEFAULT_ORDER_COLUMN,
                direction: $this->default_order_direction ?? self::DEFAULT_ORDER_DIRECTION
            );
    }
}
