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
        'firstname',
        'name',
        'photo_profile',
        'email',
        'password',
        'type_user'
    ];

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

    public function isAdmin(): bool
    {
        return $this->type_user === 'admin';
    }
}
