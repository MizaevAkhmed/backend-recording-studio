<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::create([
            'material_id' => '1',
            'content' => 'Советы и рекомендации по улучшению качества звука в подкастах, включая выбор оборудования, настройки и подходы к записи.',
        ]);
    }
}

