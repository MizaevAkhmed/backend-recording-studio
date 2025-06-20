<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'path'];
    protected $appends = ['file_url'];

    // Связь с моделью News (многие к одному)
    public function news()
    {
        return $this->belongsTo(News::class);  // Обратная связь с News
    }

    // Полный URL к файлу
    public function getFileUrlAttribute()
    {
        if (!$this->path) {
            return null;
        }
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }
        return asset('storage/' . $this->path);
    }
}
