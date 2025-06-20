<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';

    protected $fillable = [
        'user_id',
        'title',
        'data_type_id',
        'file',
        'content',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dataType()
    {
        return $this->belongsTo(DataType::class, 'data_type_id');
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return null;
        }
        // Если file уже внешняя ссылка — вернуть её
        if (filter_var($this->file, FILTER_VALIDATE_URL)) {
            return $this->file;
        }
        // Иначе считаем, что это относительный путь внутри storage/app/public/
        return asset('storage/' . $this->file);
    }
}

