<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function isAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }


    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_USER => 'User',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            if (!$user->profile_photo) {
                $user->profile_photo = 'profile_photos/default.jpeg';
                $user->save();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'remember_token',
        'profile_photo',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (is_null($user->profile_photo)) {
                $user->profile_photo = 'profile_photos/default.jpeg';
            }
        });
    }
}
