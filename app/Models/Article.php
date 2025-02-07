<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // Столбцы, которые могут быть массово назначены
    protected $fillable = ['material_id', 'title', 'content', 'image', 'description'];

    // Связь с материалом
    public function material()
    {
        return $this->belongsTo(Material::class); // Каждый article связан с одним материалом
    }
}
