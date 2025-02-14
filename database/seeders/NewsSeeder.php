<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        News::create([
            'title' => 'Открытие новой студии звукозаписи',
            'content' => 'Сегодня открыта новая студия звукозаписи в клубе ГГНТУ. Все студенты и преподаватели могут воспользоваться услугами студии для записи подкастов, лекций и других материалов.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        News::create([
            'title' => 'Мастер-класс по записи подкастов',
            'content' => 'Запланирован мастер-класс по записи подкастов, который состоится на следующей неделе. Все желающие могут записаться заранее.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        News::create([
            'title' => 'Обновление оборудования в студии',
            'content' => 'В студии обновлено оборудование: установлены новые микрофоны и звуковые карты для улучшения качества записи.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
