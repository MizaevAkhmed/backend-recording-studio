<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Photo::create([
            'title' => 'Запись подкаста на студии',
            'description' => 'Студенты записывают подкаст на студии клуба.',
            'category_id' => '4',
            'file_path' => 'uploads\images\students_record_of_podcast.webp',
        ]);

        Photo::create([
            'title' => 'Фото студии клуба',
            'description' => 'Фото студии клуба.',
            'category_id' => '4',
            'file_path' => 'uploads\images\photo-studio-for-podcasts.jpeg',
        ]);
    }
}
