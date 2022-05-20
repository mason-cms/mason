<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function get($name)
    {
        if ($setting = static::where('name', $name)->first()) {
            return $setting->value;
        }
    }

    public static function set($name, $value)
    {
        $setting = static::firstOrCreate(['name' => $name]);
        return $setting->update(['value' => $value]);
    }

    public function getValueAttribute()
    {
        return isset($this->attributes['value']) ? unserialize($this->attributes['value']) : null;
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = isset($value) ? serialize($value) : null;
    }
}
