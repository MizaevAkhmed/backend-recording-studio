<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run()
    {
        Gallery::create([
            'title' => 'Запись подкаста на студии',
            'description' => 'Студенты записывают подкаст на студии клуба.',
            'category_id' => '4',
            'file_path' => 'uploads\images\students_record_of_podcast.webp',
        ]);

        Gallery::create([
            'title' => 'Учебная лекция',
            'description' => 'Преподаватель проводит учебную лекцию.',
            'category_id' => '4',
            'file_path' => 'image2.jpg',
        ]);

        Gallery::create([
            'title' => 'Процесс записи видео',
            'description' => 'Запись образовательного видео на студии.',
            'category_id' => '4',
            'file_path' => 'image3.jpg',
        ]);
    }
}

