<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    public function location()
    {
        return $this->belongsTo(MenuLocation::class);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
