<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type_notification_id',
        'message',
        'read_at',
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с типом уведомления
    public function typeNotification()
    {
        return $this->belongsTo(TypeNotification::class, 'type_notification_id');
    }
}
