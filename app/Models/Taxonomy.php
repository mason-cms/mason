<?php

namespace App\Models;

use App\Traits\Cancellable;
use App\Traits\MenuItemable;
use App\Traits\Metable;
use App\Traits\Translatable;
use App\Traits\Urlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Taxonomy extends Model
{
    use HasFactory,
        SoftDeletes,
        Metable,
        Cancellable,
        MenuItemable,
        Translatable,
        Urlable;

    const ICON = 'fa-tags';

    protected $fillable = [
        'name',
        'title',
        'description',
        'cover_file',
        'locale_id',
        'parent_id',
    ];

    protected $casts = [
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
            $builder->orderBy('title');
        });

        static::saving(function ($taxonomy) {
            $taxonomy->name ??= Str::slug($taxonomy->title);
        });
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

    public function scopeByType(Builder $query, mixed $taxonomyType): Builder
    {
        return $query->whereIn('type_id', prepareValueForScope($taxonomyType, TaxonomyType::class));
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeByLocale(Builder $query, mixed $locale): Builder
    {
        return $query->whereIn('locale_id', prepareValueForScope($locale, Locale::class));
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['locale_id'])) {
            $query->byLocale($filters['locale_id']);
        }

        return $query;
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query
            ->where('title', 'LIKE', "%{$term}%")
            ->orWhere('name', 'LIKE', "%{$term}%");
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

    public function path(mixed $entryType = null, array $parameters = [], bool $absolute = true): ?string
    {
        if ($this->exists()) {
            if ($entryType instanceof EntryType) {
                $entryType = $entryType->name;
            }

            if (isset($this->locale) && ! $this->locale->is_default) {
                return route('locale.taxonomy', array_merge($parameters, [
                    'locale' => $this->locale->name,
                    'taxonomyType' => $this->type,
                    'taxonomy' => $this,
                    'entryType' => $entryType ?? null,
                ]), $absolute);
            } else {
                return route('taxonomy', array_merge($parameters, [
                    'taxonomyType' => $this->type,
                    'taxonomy' => $this,
                    'entryType' => $entryType ?? null,
                ]), $absolute);
            }
        }

        return null;
    }

    public function getAllChildren(): Collection
    {
        $children = collect();

        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->children);
        }

        return $children;
    }

    public function getParentOptions(): EloquentCollection
    {
        $allChildren = $this->getAllChildren();
        $allChildrenIds = $allChildren->pluck('id');

        return static::byType($this->type)
            ->where('id', '!=', $this->id)
            ->whereNotIn('id', $allChildrenIds)
            ->get();
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
            "taxonomy.{$this->name}",
            "taxonomy.default",
            "taxonomy",
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

    public function setCoverFileAttribute(File|UploadedFile $file): void
    {
        $media = new Medium(['file' => $file]);
        $media->parent()->associate($this);

        if ($media->save()) {
            $this->cover()->associate($media);
        }
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function type(): BelongsTo
    {
        return $this->belongsTo(TaxonomyType::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(Medium::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Taxonomy::class, 'parent_id');
    }

    public function entries(): BelongsToMany
    {
        return $this->belongsToMany(Entry::class);
    }
}
