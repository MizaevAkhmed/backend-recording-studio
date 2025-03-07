<?php

namespace Database\Seeders;

use App\Models\DataType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataType::create([
            'name' => 'аудио лекция',
            'description' => 'запись лекции',
        ]);

        DataType::create([
            'name' => 'тестовый тип',
            'description' => 'тестовый тип данных',
        ]);

        DataType::create([
            'name' => 'озвучка книги',
            'description' => 'запись с озвучкой книги',
        ]);

        DataType::create([
            'name' => 'другое',
            'description' => 'Другой тип записываемого материала',
        ]);
    }
}
