<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        // Видео, привязанное к материалам
        Video::create([
            'title' => 'Видео 1',
            'file_path' => 'https://example.com/video1.mp4',
            'galleryable_id' => 1, // Пример ID материала или другой связанной сущности
            'galleryable_type' => 'App\Models\Material',
        ]);

        Video::create([
            'title' => 'Видео 2',
            'file_path' => 'https://example.com/video2.mp4',
            'galleryable_id' => 2,
            'galleryable_type' => 'App\Models\Material',
        ]);

        // Видео, привязанное к галерее
        Video::create([
            'title' => 'Запись обучения студентов',
            'file_path' => 'uploads/videos/students_record_of_video.mp4',
            'galleryable_id' => 3, // ID записи в Gallery
            'galleryable_type' => 'App\Models\Gallery',
        ]);

        Video::create([
            'title' => 'Процесс обучения студентов',
            'file_path' => 'uploads/videos/education_process.mp4',
            'galleryable_id' => 4,
            'galleryable_type' => 'App\Models\Gallery',
        ]);
    }
}
