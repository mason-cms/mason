<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function target()
    {
        return $this->morphTo();
    }
}
