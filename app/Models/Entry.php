<?php

namespace App\Models;

use App\Enums\EditorMode;
use App\Facades\Parser;
use App\Traits\MenuItemable;
use App\Traits\Metable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Entry extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable,
        MenuItemable;

    const ICON = 'fa-file';

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_SCHEDULED = 'scheduled';

    protected $fillable = [
        'name',
        'locale_id',
        'title',
        'content',
        'base64_content',
        'editor_mode',
        'summary',
        'author_id',
        'is_home',
        'cover_id',
        'cover_file',
        'published_at',
        'taxonomies',
    ];

    protected $casts = [
        'editor_mode' => EditorMode::class,
        'is_home' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'is_home' => false,
    ];

    /**
     * ==================================================
     * Static Methods
     * ==================================================
     */

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Entry $entry) {
            $entry->editor_mode ??= isset($entry->type)
                ? $entry->type->default_editor_mode
                : EditorMode::WYSIWYG;
        });

        static::saving(function (Entry $entry) {
            $entry->name ??= Str::slug($entry->title);
        });

        static::saved(function (Entry $entry) {
            if ($entry->is_home) {
                $conflicts = Entry::home()->byLocale($entry->locale)->not($entry)->get();

                foreach ($conflicts as $conflict) {
                    $conflict->update(['is_home' => false]);
                }
            }
        });
    }

    public static function statusOptions()
    {
        return [static::STATUS_DRAFT, static::STATUS_PUBLISHED, static::STATUS_SCHEDULED];
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeByName(Builder $query, $name): Builder
    {
        return is_iterable($name)
            ? $query->whereIn('name', $name)
            : $query->where('name', $name);
    }

    public function scopeByType(Builder $query, mixed $entryType): Builder
    {
        return $query->whereIn('type_id', prepareValueForScope($entryType, EntryType::class));
    }

    public function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public function scopeByAuthor(Builder $query, mixed $author): Builder
    {
        return $query->whereIn('author_id', prepareValueForScope($author, User::class));
    }

    public function scopeNot(Builder $query, Entry $entry): Builder
    {
        return $query->where($entry->getKeyName(), '!=', $entry->getKey());
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        switch ($status) {
            case static::STATUS_DRAFT:
                return $query->whereNull('published_at');

            case static::STATUS_PUBLISHED:
                return $query->where('published_at', '<=', now());

            case static::STATUS_SCHEDULED:
                return $query->where('published_at', '>', now());
        }

        throw new \Exception("Invalid status: {$status}");
    }

    public function scopeHome(Builder $query, bool $isHome = true): Builder
    {
        return $query->where('is_home', $isHome);
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
        return $query
            ->where('name', 'LIKE', "%{$term}%")
            ->orWhere('title', 'LIKE', "%{$term}%")
            ->orWhere('content', 'LIKE', "%{$term}%")
            ->orWhere('summary', 'LIKE', "%{$term}%");
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

    public function getUrl(bool $absolute = true): ?string
    {
        if ($this->exists && $entry = $this) {
            if (isset($this->locale) && ! $this->locale->is_default) {
                return route('locale.entry', ['locale' => $this->locale->name, $entry], $absolute);
            } else {
                return route('entry', [$entry], $absolute);
            }
        }

        return null;
    }

    public function publish(): bool
    {
        return $this->update(['published_at' => now()]);
    }

    public function view(): ?string
    {
        $views = [
            "{$this->locale->name}.{$this->type->name}.{$this->name}",
            "{$this->locale->name}.{$this->type->name}.default",
            "{$this->locale->name}.{$this->type->name}",
            "{$this->type->name}.{$this->name}",
            "{$this->type->name}.default",
            "{$this->type->name}",
            "entry.{$this->name}",
            "entry.default",
            "entry",
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
     * Accessors & Mutators
     * ==================================================
     */

    public function setBase64ContentAttribute($value): void
    {
        $this->content = base64_decode($value);
    }

    public function getTextAttribute(): ?string
    {
        return strip_tags($this->attributes['content']);
    }

    public function getStatusAttribute(): string
    {
        if (isset($this->published_at)) {
            if ($this->published_at <= now()) {
                return static::STATUS_PUBLISHED;
            } else {
                return static::STATUS_SCHEDULED;
            }
        } else {
            return static::STATUS_DRAFT;
        }
    }

    public function getUrlAttribute(): ?string
    {
        return $this->getUrl(true);
    }

    public function getAbsoluteUrlAttribute(): ?string
    {
        return $this->getUrl(true);
    }

    public function getRelativeUrlAttribute(): ?string
    {
        return $this->getUrl(false);
    }

    public function setCoverFileAttribute($file): void
    {
        $medium = new Medium(['file' => $file]);
        $medium->parent()->associate($this);

        if ($medium->save()) {
            $this->cover()->associate($medium);
        }
    }

    public function setTaxonomiesAttribute($taxonomies): void
    {
        $this->taxonomies()->sync($taxonomies);
    }

    public function getHtmlAttribute(): ?string
    {
        if (isset($this->content)) {
            $html = $this->content;
            $html = Parser::process($html);
            return $html;
        }

        return null;
    }

    public function getPreviewAttribute(): ?string
    {
        return Parser::truncate($this->summary ?? $this->html);
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function type(): BelongsTo
    {
        return $this->belongsTo(EntryType::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(Medium::class);
    }

    public function taxonomies(): BelongsToMany
    {
        return $this->belongsToMany(Taxonomy::class);
    }
}
