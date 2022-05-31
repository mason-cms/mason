<?php

namespace App\Traits;

use App\Models\Meta;

trait Cancellable
{
    public function getIsCancellableAttribute()
    {
        return isset($this->created_at) && $this->created_at->diffInSeconds() < 5;
    }
}
