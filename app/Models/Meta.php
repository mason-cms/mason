<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use HasFactory, SoftDeletes;

    public function parent()
    {
        return $this->morphTo();
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = isset($value) ? serialize($value) : null;
    }

    public function getValueAttribute()
    {
        return isset($this->attributes['value']) ? unserialize($this->attributes['value']) : null;
    }
}
