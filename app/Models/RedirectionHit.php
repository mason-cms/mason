<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedirectionHit extends Model
{
    use HasFactory;

    public function redirection(): BelongsTo
    {
        return $this->belongsTo(Redirection::class);
    }
}
