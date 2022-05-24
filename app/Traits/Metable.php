<?php

namespace App\Traits;

use App\Models\Meta;

trait Metable
{
    public function meta()
    {
        return $this->morphToMany(Meta::class, 'parent');
    }
}
