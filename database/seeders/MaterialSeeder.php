<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        Material::create([
            'user_id' => '1',
            'title' => 'тестовая статья',
            'data_type_id' => '2',
            'file' => '',
            'content' => 'тест тест тест',
            'description' => 'тестовая статья для тестирования страницы',
        ]);
    }
}

