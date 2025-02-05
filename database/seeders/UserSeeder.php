<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Алихан Абдуллаев',
            'email' => 'alihan@example.com',
            'password' => bcrypt('password123'),
            'type_user' => 'student',
        ]);

        User::create([
            'name' => 'Рамзан Ахмадов',
            'email' => 'ramzan@example.com',
            'password' => bcrypt('password123'),
            'type_user' => 'teacher',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin123'),
            'type_user' => 'admin',
        ]);
    }
}

