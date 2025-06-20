<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'firstname' => 'Абдуллаев',
            'name' => 'Алихан',
            'photo_profile' => 'profile_photos/preparation-for-recording-a-video-lecture.jpeg',
            'email' => 'alihan@example.com',
            'password' => bcrypt('password123'),
            'type_user' => 'student',
        ]);

        User::create([
            'firstname' => 'Ахмадов',
            'name' => 'Рамзан',
            'photo_profile' => 'profile_photos/preparation-for-recording-a-video-lecture.jpeg',
            'email' => 'ramzan@example.com',
            'password' => bcrypt('password123'),
            'type_user' => 'teacher',
        ]);

        User::create([
            'firstname' => 'Администратор',
            'name' => 'Сайта',
            'photo_profile' => 'profile_photos/preparation-for-recording-a-video-lecture.jpeg',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin123'),
            'type_user' => 'system_admin',
        ]);

        User::create([
            'firstname' => 'Администратор',
            'name' => 'Студии',
            'photo_profile' => 'profile_photos/preparation-for-recording-a-video-lecture.jpeg',
            'email' => 'adminStudio@example.com',
            'password' => bcrypt('Admin123'),
            'type_user' => 'studio_admin',
        ]);
    }
}

