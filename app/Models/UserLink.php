<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLink extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'title',
        'url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
