<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        Notification::create([
            'user_id' => 1,
            'type_notification_id' => 1, // Предположим, что это уведомление типа "новый материал"
            'message' => 'Новый материал был загружен для категории Подкасты.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Notification::create([
            'user_id' => 2,
            'type_notification_id' => 2, // Уведомление типа "новое событие"
            'message' => 'Запланирована новая лекция по звукозаписи.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Notification::create([
            'user_id' => 3,
            'type_notification_id' => 3, // Уведомление типа "системное"
            'message' => 'Обновление системы на студии завершено.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
