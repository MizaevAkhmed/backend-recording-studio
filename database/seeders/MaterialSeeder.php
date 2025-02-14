<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Article;
use App\Models\Podcast;
use App\Models\Video;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        // Создаём статью
        $article = Article::create([
            'title' => 'Как писать код',
            'content' => 'Это учебная статья о программировании...',
            'file_path' => 'uploads/articles/code.jpg',
            'description' => 'Основы программирования на Laravel',
        ]);

        Material::create([
            'user_id' => 2, // Студент
            'category_id' => 1, // Статьи
            'materialable_id' => $article->id,
            'materialable_type' => Article::class,
        ]);

        // Создаём подкаст
        $podcast = Podcast::create([
            'title' => 'История технологий',
            'file_path' => 'uploads/podcasts/history.mp3',
            'description' => 'Обсуждаем историю IT',
        ]);

        Material::create([
            'user_id' => 3, // Преподаватель
            'category_id' => 2, // Подкасты
            'materialable_id' => $podcast->id,
            'materialable_type' => Podcast::class,
        ]);

        // Создаём видео
        $video = Video::create([
            'title' => 'Введение в Laravel',
            'file_path' => 'uploads/videos/laravel.mp4',
        ]);

        Material::create([
            'user_id' => 1, // Админ
            'category_id' => 3, // Видеолекции
            'materialable_id' => $video->id,
            'materialable_type' => Video::class,
        ]);
    }
}

