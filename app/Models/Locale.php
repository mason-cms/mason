<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'region',
        'title',
        'is_default',
    ];

    /**
     * Static Methods
     */

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    public static function default()
    {
        return static::where('is_default', true)->first()
            ?? static::findByName(config('app.locale'));
    }

    /**
     * Helpers
     */

    public function __toString()
    {
        return "{$this->title}";
    }

    /**
     * Accessors & Mutators
     */

    public function getCodeAttribute()
    {
        return "{$this->name}_{$this->region}";
    }
}
