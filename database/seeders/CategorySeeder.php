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
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        Category::create([
            'name' => 'Статьи',
            'description' => 'Текстовые материалы и статьи',
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        Category::create([
            'name' => 'Видеолекции',
            'description' => 'Образовательные видео и лекции',
            'created_at' => now(), 
            'updated_at' => now()
        ]);
        
        Category::create([
            'name' => 'Фотоматериалы',
            'description' => 'Фотографии и иллюстрации',
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        Category::create([
            'name' => 'Видеоматериалы',
            'description' => 'Видеоролики и видеоинструкции',
            'created_at' => now(), 
            'updated_at' => now()
        ]);
    }
}

