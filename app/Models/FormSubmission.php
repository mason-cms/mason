<?php

namespace App\Models;

use App\Mail\FormSubmissionMailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FormSubmission extends Model
{
    use HasFactory,
        SoftDeletes;

    const ICON = 'fa-clipboard-list-check';

    protected $fillable = [
        'input',
        'user_agent',
        'user_ip',
        'referrer_url',
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

        static::creating(function (self $submission) {
            if ($authUser = auth()->user()) {
                $submission->user()->associate($authUser);
            }
        });
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function setInputAttribute(array $input = null)
    {
        if (isset($input)) {
            // Iterate over input and convert uploaded files to links
            foreach ($input as &$value) {
                if (is_array($value)) {
                    foreach ($value as &$v) {
                        if ($v instanceof UploadedFile) {
                            $v = htmlLink(
                                url: $this->storeFile($v),
                                text: $v->getClientOriginalName(),
                            );
                        }
                    }
                } elseif ($value instanceof UploadedFile) {
                    $value = htmlLink(
                        url: $this->storeFile($value),
                        text: $value->getClientOriginalName(),
                    );
                }
            }
        }

        $this->attributes['input'] = isset($input)
            ? json_encode($input)
            : null;
    }

    public function getInputAttribute(): ?array
    {
        return isset($this->attributes['input'])
            ? json_decode($this->attributes['input'], true)
            : null;
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function storeFile(UploadedFile|File $file)
    {
        $storageKey = $file->store("forms/{$this->form->id}/uploads", ['public' => true]);
        return Storage::url($storageKey);
    }

    public function data(): array
    {
        $data = [];

        if (isset($this->input)) {
            foreach ($this->input as $fieldName => $value) {
                if (str_starts_with($fieldName, '_')) {
                    continue;
                }

                $field = $this->form->fields()->byName($fieldName)->first();

                $data[] = [
                    'field' => isset($field) ? $field->label : $fieldName,
                    'value' => $value,
                ];
            }
        }

        return $data;
    }

    public function send(string|array $to = null): SentMessage
    {
        $to ??= $this->form?->send_to;

        if (is_string($to)) {
            $to = array_map('trim', explode(',', $to));
        }

        return Mail::to($to)
            ->send(new FormSubmissionMailable($this));
    }
}
