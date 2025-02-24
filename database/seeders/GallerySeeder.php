<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run()
    {
        Gallery::create([
            'title' => 'Процесс записи видео',
            'description' => 'Запись образовательного видео на студии.',
            'category_id' => '5',
            'file_path' => 'uploads\images\students_record_of_video.mp4',
        ]);

        Gallery::create([
            'title' => 'Процесс обучения студентов',
            'description' => 'Запись образовательного видео на студии.',
            'category_id' => '5',
            'file_path' => 'uploads\images\students_record_of_video.mp4',
        ]);
    }
}

