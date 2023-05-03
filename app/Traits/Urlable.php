<?php

namespace App\Traits;

use App\Models\Meta;

trait Urlable
{
    public function getUrlAttribute(): ?string
    {
        return $this->path();
    }

    public function getAbsoluteUrlAttribute(): ?string
    {
        return $this->path(absolute: true);
    }

    public function getRelativeUrlAttribute(): ?string
    {
        return $this->path(absolute: false);
    }
}
