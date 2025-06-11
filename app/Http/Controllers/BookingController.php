<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DataType;
use App\Models\NonworkingDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class BookingController extends Controller
{
    // Получение списка бронирований текущего пользователя
    public function userBookings()
    {
        return response()->json(
            Booking::with(['dataType'])
                ->where('user_id', Auth::id())
                ->get()
        );
    }

    // Получение списка бронирований для админа
    public function adminBookings()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(
            Booking::with(['user', 'type'])->get()
        );
    }

    // Просмотр конкретного бронирования
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking, 200);
    }

    // Создание нового бронирования
    public function store(Request $request)
    {
        $request->validate([
            'data_type_id' => 'required|exists:data_types,id',
            'description' => 'nullable|string',
            'recording_start_date' => 'required|date',
            'end_date_of_recording' => 'required|date|after:recording_start_date',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'data_type_id' => $request->data_type_id,
            'description' => $request->description,
            'recording_start_date' => $request->recording_start_date,
            'end_date_of_recording' => $request->end_date_of_recording,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Бронь успешно создана',
            'booking' => $booking
        ]);
    }

    // Обновление бронирования
    public function update(Request $request, Booking $booking)
    {
        // Проверяем, имеет ли пользователь права на редактирование
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'У вас нет прав для редактирования'], 403);
        }

        // Обновляем бронирование
        $booking->update([
            'data_type_id' => $request->data_type_id ?? $booking->data_type_id,
            'description' => $request->description ?? $booking->description,
            'recording_start_date' => $request->recording_start_date ?? $booking->recording_start_date,
            'end_date_of_recording' => $request->end_date_of_recording ?? $booking->end_date_of_recording,
            'status' => $request->status ?? $booking->status
        ]);

        return response()->json([
            'message' => 'Бронь успешно обновлена',
            'booking' => $booking
        ]);
    }

    // Удаление бронирования
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // Проверка доступа: удалить может только владелец или админ
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'У вас нет прав для удаления'], 403);
        }

        $booking->delete();

        return response()->json(['message' => 'Бронь успешно удалена']);
    }

    // Получение массива с нерабочими днями, забронированными днями и типами данных для бронирования
    public function getBookingData()
    {
        // Получаем все нерабочие дни
        $nonWorkingDays = NonworkingDay::pluck('date')->toArray();

        // Получаем все диапазоны забронированных дней
        $bookings = Booking::select('recording_start_date', 'end_date_of_recording')->get();

        // Создаем массив с забронированными днями
        $bookedDates = [];

        foreach ($bookings as $booking) {
            $startDate = new DateTime($booking->recording_start_date);
            $endDate = new DateTime($booking->end_date_of_recording);

            // Генерируем все даты в этом диапазоне
            while ($startDate <= $endDate) {
                $bookedDates[] = $startDate->format('Y-m-d');
                $startDate->modify('+1 day'); // Увеличиваем на 1 день
            }
        }

        // Убираем дубликаты
        $bookedDates = array_values(array_unique($bookedDates));

        // Получаем массив с типами данных для бронирование
        $dataTypes = DataType::all();

        return response()->json([
            'holidays' => $nonWorkingDays,
            'bookedDates' => $bookedDates,
            'dataTypes' => $dataTypes
        ]);
    }
}
