<?php

namespace Database\Seeders;

use App\Models\TypeNotification;
use Illuminate\Database\Seeder;

class TypeNotificationSeeder extends Seeder
{
    public function run()
    {
        TypeNotification::create([
            'name' => 'Новый материал',
            'description' => 'Уведомление о новом материале, доступном для студентов.',
        ]);

        TypeNotification::create([
            'name' => 'Новое событие',
            'description' => 'Уведомление о новых событиях на студии, таких как лекции и мастер-классы.',
        ]);

        TypeNotification::create([
            'name' => 'Системное',
            'description' => 'Уведомления, касающиеся изменений в работе системы.',
        ]);
    }
}

