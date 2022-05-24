<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'singular_title',
        'plural_title',
        'icon_class',
    ];

    public function __toString()
    {
        return "{$this->plural_title}";
    }
}
