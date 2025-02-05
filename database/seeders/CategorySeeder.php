<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Подкасты',
            'description' => 'Аудиоматериалы для подкастов',
        ]);

        Category::create([
            'name' => 'Статьи',
            'description' => 'Текстовые материалы и статьи',
        ]);

        Category::create([
            'name' => 'Видеолекции',
            'description' => 'Образовательные видео и лекции',
        ]);
        
        Category::create([
            'name' => 'Фотоматериалы',
            'description' => 'Фотографии и иллюстрации',
        ]);

        Category::create([
            'name' => 'Видеоматериалы',
            'description' => 'Видеоролики и видеоинструкции',
        ]);
    }
}

