<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuLocation extends Model
{
    use HasFactory, SoftDeletes;

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
