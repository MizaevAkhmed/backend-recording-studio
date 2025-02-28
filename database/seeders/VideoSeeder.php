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
            'description' => 'Обучающее видео для студентов',
        ]);

        // Видео, привязанное к галерее
        Video::create([
            'title' => 'Видео 2',
            'file_path' => 'https://example.com/video2.mp4',
            'description' => 'Тестовое видео',
        ]);
    }
}
