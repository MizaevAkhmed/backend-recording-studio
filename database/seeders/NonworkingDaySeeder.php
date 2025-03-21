<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NonworkingDay;
use Carbon\Carbon;

class NonworkingDaySeeder extends Seeder
{
    public function run()
    {
        $holidays = [
            ['date' => '2025-01-01', 'reason' => 'Новый год'],
            ['date' => '2025-01-02', 'reason' => 'Новогодние каникулы'],
            ['date' => '2025-01-03', 'reason' => 'Новогодние каникулы'],
            ['date' => '2025-01-04', 'reason' => 'Новогодние каникулы'],
            ['date' => '2025-01-05', 'reason' => 'Новогодние каникулы'],
            ['date' => '2025-01-06', 'reason' => 'Новогодние каникулы'],
            ['date' => '2025-01-07', 'reason' => 'Рождество Христово'],
            ['date' => '2025-02-23', 'reason' => 'День защитника Отечества'],
            ['date' => '2025-03-08', 'reason' => 'Международный женский день'],
            ['date' => '2025-05-01', 'reason' => 'Праздник Весны и Труда'],
            ['date' => '2025-05-09', 'reason' => 'День Победы'],
            ['date' => '2025-06-12', 'reason' => 'День России'],
            ['date' => '2025-11-04', 'reason' => 'День народного единства'],
            ['date' => '2025-03-31', 'reason' => 'Начало Рамадана'],
            ['date' => '2025-04-29', 'reason' => 'Ночь Предопределения (Ляйлятуль-Кадр)'],
            ['date' => '2025-05-30', 'reason' => 'Ураза-байрам (Ид аль-Фитр)'],
            ['date' => '2025-07-07', 'reason' => 'День Арафа'],
            ['date' => '2025-07-08', 'reason' => 'Курбан-байрам (Ид аль-Адха)'],
            ['date' => '2025-09-26', 'reason' => 'Мавлид ан-Наби (Рождение Пророка Мухаммада)'],
            ['date' => '2025-04-23', 'reason' => 'День чеченской женщины'],
            ['date' => '2025-10-05', 'reason' => 'День Грозного'],
        ];

        foreach ($holidays as &$holiday) {
            $holiday['created_at'] = Carbon::now();
            $holiday['updated_at'] = Carbon::now();
        }

        NonworkingDay::insert($holidays);
    }
}
