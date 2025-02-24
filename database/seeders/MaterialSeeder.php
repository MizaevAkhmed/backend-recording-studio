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
        Material::create([
            'user_id' => 2, // Студент
            'category_id' => 1, // Статьи
            'materialable_id' => 1,
            'materialable_type' => Article::class,
        ]);

        Material::create([
            'user_id' => 3, // Преподаватель
            'category_id' => 2, // Подкасты
            'materialable_id' => 1,
            'materialable_type' => Podcast::class,
        ]);

        Material::create([
            'user_id' => 1, // Админ
            'category_id' => 3, // Видеолекции
            'materialable_id' => 1,
            'materialable_type' => Video::class,
        ]);
    }
}

