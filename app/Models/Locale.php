<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
    ];

    public static function default()
    {
        if ($defaultLocaleName = Setting::get('site_default_locale')) {
            return static::where('name', $defaultLocaleName)->first();
        }
    }

    public function __toString()
    {
        return "{$this->title}";
    }
}
