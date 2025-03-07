<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DataTypeSeeder::class,
            NonworkingDaySeeder::class,
            TypeNotificationSeeder::class,
            NotificationSeeder::class,
            BookingSeeder::class,
            MaterialSeeder::class,
            NewsSeeder::class,
        ]);
    }
}

