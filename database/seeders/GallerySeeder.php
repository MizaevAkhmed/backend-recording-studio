<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Video;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run()
    {
        Gallery::create([
            'category_id' => 4,
            'galleryable_id' => 1,
            'galleryable_type' => Photo::class,
        ]);

        Gallery::create([
            'category_id' => 4,
            'galleryable_id' => 2,
            'galleryable_type' => Photo::class,
        ]);

        Gallery::create([
            'category_id' => 5,
            'galleryable_id' => 1,
            'galleryable_type' => Video::class,
        ]);

        Gallery::create([
            'category_id' => 5,
            'galleryable_id' => 2,
            'galleryable_type' => Video::class,
        ]);
    }
}

