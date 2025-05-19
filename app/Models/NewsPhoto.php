<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'path'];

    // Связь с моделью News (многие к одному)
    public function news()
    {
        return $this->belongsTo(News::class);  // Обратная связь с News
    }
}
