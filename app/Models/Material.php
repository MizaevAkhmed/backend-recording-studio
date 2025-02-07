<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    // Столбцы, которые могут быть массово назначены
    protected $fillable = ['user_id', 'category_id'];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class); // Один материал принадлежит одному пользователю
    }

    // Связь с категорией
    public function category()
    {
        return $this->belongsTo(Category::class); // Один материал имеет одну категорию
    }

    // Связь с статьями (если есть)
    public function articles()
    {
        return $this->hasMany(Article::class); // Один материал может иметь много статей
    }

    // Связь с подкастами (если есть)
    public function podcasts()
    {
        return $this->hasMany(Podcast::class); // Один материал может иметь много подкастов
    }

    // Связь с видео (если есть)
    public function videos()
    {
        return $this->hasMany(Video::class); // Один материал может иметь много видео
    }
}
