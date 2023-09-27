<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory,
        Translatable,
        SoftDeletes;

    const ICON = 'fa-clipboard-list';

    protected $fillable = [
        'title',
        'name',
        'description',
        'locale_id',
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

        static::saving(function (self $form) {
            $form->name ??= Str::slug($form->title);
        });

        static::deleted(function (self $form) {
            $form->fields()->delete();
            $form->submissions()->delete();
        });
    }

    /**
     * ==================================================
     * Scopes
     * ==================================================
     */

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query
            ->where('name', 'LIKE', "%{$term}%");
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (isset($filters['locale_id'])) {
            $query->byLocale($filters['locale_id']);
        }

        return $query;
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

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
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
            "{$this->locale->name}.forms.{$this->name}",
            "{$this->locale->name}.forms.default",
            "{$this->locale->name}.form",
            "forms.{$this->name}",
            "forms.default",
            "form",
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
            return view($view, array_merge($data, ['form' => $this]))->render();
        }

        return null;
    }
}
