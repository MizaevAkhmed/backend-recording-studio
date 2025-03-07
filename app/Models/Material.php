<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';

    protected $fillable = [
        'user_id',
        'title',
        'data_type_id',
        'file_path',
        'content',
        'description',
    ];

    public function dataType()
    {
        return $this->belongsTo(DataType::class, 'data_type_id');
    }
}

