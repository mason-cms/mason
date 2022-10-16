<?php

namespace App\Models;

use App\Traits\Cancellable;
use App\Traits\Metable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        Cancellable,
        Metable;

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

    public function __toString()
    {
        return "{$this->name}";
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function getGravatarUrlAttribute()
    {
        if (isset($this->email)) {
            $hash = md5(strtolower($this->email));
            return "https://www.gravatar.com/avatar/{$hash}";
        }
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function entries()
    {
        return $this->hasMany(Entry::class, 'author_id');
    }
}
