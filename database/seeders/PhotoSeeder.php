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
            'file_path' => 'uploads\images\students_record_of_podcast.webp',
        ]);

        Photo::create([
            'title' => 'Фото студии для подкаста',
            'description' => 'Фото студии клуба.',
            'file_path' => 'uploads\images\showcasing audio recording for learning materials.png',
        ]);
    }
}
