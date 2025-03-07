<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'user_id' => 1,
            'data_type_id' => 1,
            'description' => 'Тестовая запись в студии',
            'recording_start_date' => Carbon::now(),
            'end_date_of_recording' => Carbon::now()->addDays(2)->addHours(2),
            'status' => 'booked',
        ]);
    }
}
