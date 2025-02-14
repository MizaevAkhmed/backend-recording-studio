<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'materialable_id', 'materialable_type'];

    public function materialable(): MorphTo
    {
        return $this->morphTo();
    }
}

