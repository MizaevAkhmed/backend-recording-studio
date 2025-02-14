<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'file_path', 'description'];

    public function material(): MorphOne
    {
        return $this->morphOne(Material::class, 'materialable');
    }
}

