<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsPhoto;

class NewsPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsPhoto::create([
            'news_id' => 1,
            'path' => 'images\background-studio.jpg',
        ]);

        NewsPhoto::create([
            'news_id' => 1,
            'path' => 'images\photo-studio-for-podcasts.jpeg',
        ]);
    }
}
