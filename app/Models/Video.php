<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    // Столбцы, которые могут быть массово назначены
    protected $fillable = ['material_id', 'title', 'file_path'];

    // Связь с материалом
    public function material()
    {
        return $this->belongsTo(Material::class); // Каждое видео связано с одним материалом
    }
}
