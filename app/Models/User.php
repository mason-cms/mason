<?php

namespace App\Models;

use App\Traits\Cancellable;
use App\Traits\Metable;
use App\Traits\Resolvable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        'photo_id',
        'photo_file',
        'profiles',
        'links',
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
     * Static Methods
     * ==================================================
     */

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (self $user) {
            $locales = Locale::all();

            foreach ($locales as $locale) {
                $user->profiles()->firstOrCreate(['locale_id' => $locale->id]);
            }
        });
    }

    /**
     * ==================================================
     * Helpers
     * ==================================================
     */

    public function __toString(): string
    {
        return "{$this->name}";
    }

    public function getProfile(Locale $locale): UserProfile
    {
        return $this->profiles()->firstOrCreate([
            'locale_id' => $locale->id,
        ]);
    }

    /**
     * ==================================================
     * Accessors & Mutators
     * ==================================================
     */

    public function setPasswordAttribute(?string $value): void
    {
        if (isset($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function setPhotoFileAttribute(File|UploadedFile $file): void
    {
        $medium = new Medium(['file' => $file]);
        $medium->parent()->associate($this);
        $medium->saveOrFail();
        $this->photo()->associate($medium);
    }

    public function getGravatarUrlAttribute(): ?string
    {
        if (isset($this->email)) {
            $hash = md5(strtolower($this->email));
            return "https://www.gravatar.com/avatar/{$hash}";
        }

        return null;
    }

    public function setProfilesAttribute(?array $profiles): void
    {
        if (isset($profiles)) {
            foreach ($profiles as $attributes) {
                try {
                    if (isset($attributes['id'])) {
                        $profile = $this->profiles()->findOrFail($attributes['id']);
                        $profile->updateOrFail($attributes);
                    } else {
                        $this->profiles()->create($attributes);
                    }
                } catch (\Exception $e) {
                    \Sentry\captureException($e);
                }
            }
        }
    }

    public function setLinksAttribute(?array $links): void
    {
        if (isset($links)) {
            foreach ($links as $attributes) {
                try {
                    if (isset($attributes['id'])) {
                        $link = $this->links()->findOrFail($attributes['id']);
                        $link->updateOrFail($attributes);
                    } elseif (isset($attributes['title'], $attributes['url'])) {
                        $this->links()->create($attributes);
                    }
                } catch (\Exception $e) {
                    \Sentry\captureException($e);
                }
            }
        }
    }

    /**
     * ==================================================
     * Relationships
     * ==================================================
     */

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Medium::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'author_id');
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(UserProfile::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(UserLink::class);
    }
}
