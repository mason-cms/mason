<?php

namespace App\Models;

use App\Traits\Cancellable;
use App\Traits\Metable;
use App\Traits\Resolvable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        Cancellable,
        Metable,
        Resolvable;

    const ICON = 'fa-user-group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString(): string
    {
        return "{$this->name}";
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getGravatarUrlAttribute(): ?string
    {
        if (isset($this->email)) {
            $hash = md5(strtolower($this->email));
            return "https://www.gravatar.com/avatar/{$hash}";
        }

        return null;
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'author_id');
    }
}
