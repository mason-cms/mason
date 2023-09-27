<?php

namespace App\Models;

use App\Enums\FormFieldType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use HasFactory,
        SoftDeletes;

    const ICON = 'fa-input-text';

    protected $fillable = [
        'name',
        'type',
        'label',
        'description',
        'rank',
    ];

    protected $casts = [
        'type' => FormFieldType::class,
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

        static::creating(function (self $field) {
            if (! isset($field->rank)) {
                if (isset($field->form)) {
                    if ($lastField = $field->form->fields->last()) {
                        $field->rank = $lastField->rank + 1;
                    }
                }
            }
        });
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
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
            "{$this->form->locale->name}.forms.fields.{$this->name}",
            "{$this->form->locale->name}.forms.fields.{$this->type}",
            "{$this->form->locale->name}.forms.fields.default",
            "{$this->form->locale->name}.forms.field",
            "forms.fields.{$this->name}",
            "forms.fields.{$this->type}",
            "forms.fields.default",
            "forms.field",
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
            return view($view, array_merge($data, ['formField' => $this]))->render();
        }

        return null;
    }
}
