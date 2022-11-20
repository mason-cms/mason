<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    const ICON = 'fa-wrench';

    protected $fillable = [
        'name',
        'value',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function get(string $name): ?string
    {
        if ($setting = static::where('name', $name)->first()) {
            return $setting->value;
        }

        return null;
    }

    public static function set(string $name, mixed $value): bool
    {
        $setting = static::firstOrCreate(['name' => $name]);

        return $setting->update(['value' => $value]);
    }

    public function getValueAttribute(): ?string
    {
        return isset($this->attributes['value'])
            ? unserialize($this->attributes['value'])
            : null;
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = isset($value)
            ? serialize($value)
            : null;
    }
}
