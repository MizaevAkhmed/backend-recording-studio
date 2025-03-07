<?php

namespace Database\Seeders;

use App\Models\NonworkingDay;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NonworkingDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($year = 2025; $year <= 2025; $year++){
            for ($month = 1; $month <= 12; $month++){
                // Получаем все субботы и воскресенья для месяца
                $startDate = Carbon::createFromDate($year, $month, 1);
                $endDate = $startDate->copy()->endOfMonth();

                while ($startDate <= $endDate){
                    if ($startDate->isWeekend()){
                        NonworkingDay::create([
                            'date' => $startDate->format('Y-m-d'),
                            'reason' => 'Weekend',
                        ]);
                    }
                    $startDate->addDay();
                }
            }
        }
    }
}
