<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $fillable = ['category_id', 'galleryable_type','galleryable_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleryable(): MorphTo
    {
        return $this->morphTo();
    }
}
