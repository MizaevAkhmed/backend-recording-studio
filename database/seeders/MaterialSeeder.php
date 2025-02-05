<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        Material::create([
            'user_id' => 1, // Пользователь 1 (студент)
            'title' => 'Как записать подкаст',
            'description' => 'Шаг за шагом о том, как записывать подкасты с качественным звуком.',
            'category_id' => 1,
        ]);

        Material::create([
            'user_id' => 2, // Пользователь 2 (преподаватель)
            'title' => 'Введение в студийную запись',
            'description' => 'Основы звукозаписи для начинающих студентов.',
            'category_id' => 2,
        ]);

        Material::create([
            'user_id' => 2, // Пользователь 3 (преподаватель)
            'title' => 'Как выбрать оборудование для студии',
            'description' => 'Советы по выбору микрофонов, пультов и других устройств.',
            'category_id' => 3,
        ]);
    }
}

