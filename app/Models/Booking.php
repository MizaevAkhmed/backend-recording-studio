<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'user_id',
        'data_type_id',
        'description',
        'recording_start_date',
        'end_date_of_recording',
        'status',
    ];

    // Связь с таблицей пользователи
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Связь с таблицей тип записи
    public function DataType()
    {
        return $this->BelongsTo(DataType::class, 'data_type_id');
    }
}
