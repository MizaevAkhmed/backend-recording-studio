<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'file_path'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
