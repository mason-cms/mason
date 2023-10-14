<?php

namespace App\Models;

use App\Enums\FormFieldType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        'placeholder',
        'default_value',
        'class',
        'rules',
        'options',
        'columns',
        'rank',
    ];

    protected $casts = [
        'type' => FormFieldType::class,
        'is_required' => 'boolean',
        'columns' => 'integer',
        'rank' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'columns' => 12,
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
            if (!isset($field->rank)) {
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
     * Scopes
     * ==================================================
     */

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query
            ->where('name', $name)
            ->orWhere('name', "{$name}[]");
    }

    public function scopeByType(Builder $query, FormFieldType $type): Builder
    {
        return $query->where('type', $type->value);
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getDotnameAttribute(): string
    {
        $dotname = $this->name;
        $dotname = Str::remove('[]', $dotname);
        $dotname = Str::replace('[', '.', $dotname);
        $dotname = Str::remove(']', $dotname);
        return $dotname;
    }

    public function getRulekeyAttribute(): string
    {
        $rulekey = $this->name;
        $rulekey = Str::replace('[]', '.*', $rulekey);
        $rulekey = Str::replace('[', '.', $rulekey);
        $rulekey = Str::remove(']', $rulekey);
        return $rulekey;
    }

    public function getIsRequiredAttribute(): bool
    {
        return in_array('required', explode('|', $this->rules));
    }

    public function getIsMultipleAttribute(): bool
    {
        return str_ends_with($this->name, '[]');
    }

    public function getAcceptAttribute(): Collection
    {
        $accept = collect();

        $rules = explode('|', $this->rules);

        foreach ($rules as $rule) {
            switch ($rule) {
                case 'image':
                    $accept->push("image/*");
                    break;

                default:
                    if (str_starts_with($rule, 'mimes:')) {
                        $rule = explode(':', $rule, 2);
                        $mimes = explode(',', $rule[1]);

                        foreach ($mimes as $mime) {
                            switch ($mime) {
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'gif':
                                    $accept->push("image/{$mime}");
                                    break;

                                case 'pdf':
                                    $accept->push("application/{$mime}");
                                    break;

                                default:
                                    if (str_contains($mime, '/')) {
                                        $accept->push($mime);
                                    }
                            }
                        }
                    }
            }
        }

        return $accept;
    }

    public function getHtmlOptionsAttribute(): Collection
    {
        $options = collect();

        $lines = explode(PHP_EOL, $this->attributes['options']);
        $lines = array_map('trim', $lines);

        foreach ($lines as $line) {
            if (
                str_contains($line, ':')
                && ! str_contains($line, ': ')
                && ! str_starts_with($line, ':')
                && ! str_ends_with($line, ':')
            ) {
                $line = explode(':', $line, 2);

                $options->push([
                    'value' => $line[0],
                    'label' => $line[1],
                ]);
            } else {
                $options->push([
                    'value' => $line,
                    'label' => $line,
                ]);
            }
        }

        return $options;
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
            "{$this->form->locale->name}.forms.fields.{$this->type->value}",
            "{$this->form->locale->name}.forms.fields.default",
            "{$this->form->locale->name}.forms.field",
            "forms.fields.{$this->name}",
            "forms.fields.{$this->type->value}",
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

    public function render(array $data = []): string
    {
        if ($view = $this->view()) {
            return view($view, array_merge($data, ['field' => $this]))->render();
        }

        return "";
    }

    public function old(string $default = null): mixed
    {
        return old($this->dotname, $default);
    }
}
