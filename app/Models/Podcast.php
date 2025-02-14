<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'file_path'];

    public function material(): MorphOne
    {
        return $this->morphOne(Material::class, 'materialable');
    }
}
