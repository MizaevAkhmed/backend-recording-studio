<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'date',
        'location',
        'category_id'
    ];

    // Связь с моделью NewsCategory (многие к одному)
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    // Связь с моделью NewsPhoto (один ко многим)
    public function photos()
    {
        return $this->hasMany(NewsPhoto::class);  // Связь с моделью NewsPhoto
    }
}
