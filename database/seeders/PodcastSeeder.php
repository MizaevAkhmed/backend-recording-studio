<?php

namespace Database\Seeders;

use App\Models\Podcast;
use Illuminate\Database\Seeder;

class PodcastSeeder extends Seeder
{
    public function run()
    {
        Podcast::create([
            'material_id' => 2,
            'file_path' => 'https://example.com/podcast1.mp3'
        ]);
    }
}