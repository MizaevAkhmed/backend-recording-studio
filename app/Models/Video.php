<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'file_path'];

    public function material(): MorphOne
    {
        return $this->morphOne(Material::class, 'materialable');
    }

    public function gallery(): MorphOne
    {
        return $this->morphOne(Gallery::class, 'galleryable');
    }
}
