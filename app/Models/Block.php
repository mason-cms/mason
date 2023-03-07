<?php

namespace App\Models;

use App\Enums\EditorMode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory,
        SoftDeletes;

    const ICON = 'fa-cube';

    protected $fillable = [
        'location',
        'locale_id',
        'title',
        'content',
        'editor_mode',
        'rank',
    ];

    protected $casts = [
        'editor_mode' => EditorMode::class,
        'rank' => 'integer',
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
                ->orderBy('rank')
                ->orderBy('created_at');
        });

        static::creating(function (self $block) {
            $block->editor_mode ??= $block->default_editor_mode;
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['location'])) {
            $query->byLocation($filters['status']);
        }

        if (isset($filters['locale_id'])) {
            $query->byLocale($filters['locale_id']);
        }

        return $query;
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString()
    {
        return $this->render();
    }

    public function view(): ?string
    {
        $views = [
            "{$this->locale->name}.blocks.{$this->location}.default",
            "{$this->locale->name}.blocks.{$this->location}",
            "{$this->locale->name}.blocks.default",
            "{$this->locale->name}.blocks",
            "blocks.{$this->location}.default",
            "blocks.{$this->location}",
            "blocks.default",
            "blocks",
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }

        return null;
    }

    public function render(array $data = []): ?string
    {
        if ($view = $this->view()) {
            return view($view, array_merge($data, ['block' => $this]))->render();
        }

        return null;
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getlocationInfoAttribute(): ?object
    {
        return isset($this->location)
            ? site(false)->theme()->blockLocation($this->location)
            : null;
    }

    public function getDefaultEditorModeAttribute(): EditorMode
    {
        return isset($this->location_info, $this->location_info->defaultEditorMode)
            ? EditorMode::from($this->location_info->defaultEditorMode)
            : EditorMode::WYSIWYG;
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }
}
