<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Model
{
    use HasFactory, SoftDeletes;

    public function __toString()
    {
        return "{$this->title}";
    }

    public function parent()
    {
        return $this->belongsTo(Taxonomy::class);
    }
}
