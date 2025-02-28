<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Podcast;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Podcast::create([
            'title' => 'Подкаст о клубе',
            'description' => 'Подкаст о клубе.',
            'file_path' => 'uploads\audio\podcast_about_club.mp3',
        ]);
    }
}
