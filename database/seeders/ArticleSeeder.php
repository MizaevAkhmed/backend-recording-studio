<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::create([
            'title' => 'Советы по улучшению качества звука',
            'content' => 'Советы и рекомендации по улучшению качества звука в подкастах, включая выбор оборудования, настройки и подходы к записи.',
            'file_path' => 'uploads\images\photo-studio-for-podcasts.jpeg',
            'description' => 'Советы и рекомендации по улучшению качества звука в подкастах.',
        ]);
    }
}

