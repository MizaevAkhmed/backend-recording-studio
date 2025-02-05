<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        Video::create([
            'material_id' => 3,
            'file_path' => 'https://example.com/video1.mp4',
        ]);

        Video::create([
            'material_id' => 5,
            'file_path' => 'https://example.com/video2.mp4',
        ]);
    }
}

