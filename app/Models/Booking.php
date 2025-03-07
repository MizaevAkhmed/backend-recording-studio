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
        'record_type_id',
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
    public function RecordType()
    {
        return $this->BelongsTo(RecordType::class, 'record_type_id');
    }
}
