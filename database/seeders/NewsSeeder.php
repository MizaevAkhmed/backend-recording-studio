<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        News::create([
            'title' => 'Запуск нового курса по звукозаписи для студентов',
            'content' => 'Мы рады анонсировать запуск нового курса по звукозаписи для студентов ГГНТУ! Курс включает в себя теоретические и практические занятия...',
            'date' => '2025-02-15',
            'location' => 'Звукозаписывающая студия клуба ГГНТУ',
            'category_id' => 1 // «Курсы»
        ]);
    }
}
