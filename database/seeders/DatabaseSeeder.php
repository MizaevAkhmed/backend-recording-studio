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
            MaterialSeeder::class,
            // GallerySeeder::class,
            TypeNotificationSeeder::class,
            NotificationSeeder::class,
            NewsSeeder::class,
            VideoSeeder::class,
            ArticleSeeder::class,
            PodcastSeeder::class,
        ]);
    }
}

