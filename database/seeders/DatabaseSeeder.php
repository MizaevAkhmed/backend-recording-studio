<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            PodcastSeeder::class,
            VideoSeeder::class,
            PhotoSeeder::class,
            MaterialSeeder::class,
            GallerySeeder::class,
            NewsSeeder::class,
            TypeNotificationSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}

