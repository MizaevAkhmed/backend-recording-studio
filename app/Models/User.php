<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'firstname', 'name', 'email', 'password', 'type_user', 'photo_profile'
    ];

    protected $appends = ['photo_profile_url'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Определение связи с материалами
    public function materials()
    {
        return $this->hasMany(Material::class); // Один пользователь может иметь много материалов
    }

    public function hasRole($roles)
    {
        $roles = is_array($roles) ? $roles : func_get_args();
        return in_array($this->type_user, $roles);
    }

    public function getPhotoProfileUrlAttribute()
    {
        return $this->photo_profile
            ? asset('storage/' . $this->photo_profile)
            : null;
    }
}
