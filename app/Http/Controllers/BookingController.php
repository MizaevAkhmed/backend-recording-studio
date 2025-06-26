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
                ->where('status', '<>', 'cancelled')
                ->get()
        );
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

    // Получение списка бронирований для системного администратора и для администратора студии
    public function getAdminBookingPageData()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole(['studio_admin', 'system_admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $bookings = Booking::with([
            'user:id,id,name,firstname,email',
            'dataType:id,id,name,description'
        ])->get();

        $dataTypes = DataType::all();

        $bookedDates = [];
        foreach ($bookings as $booking) {
            $start = new \DateTime($booking->recording_start_date);
            $end = new \DateTime($booking->end_date_of_recording);
            while ($start <= $end) {
                $bookedDates[] = $start->format('Y-m-d');
                $start->modify('+1 day');
            }
        }

        $bookedDates = array_values(array_unique($bookedDates));

        return response()->json([
            'bookings' => $bookings,
            'dataTypes' => $dataTypes,
            'bookedDates' => $bookedDates,
        ]);
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
            'end_date_of_recording' => 'required|date|after_or_equal:recording_start_date',
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
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        $isAdmin = $user->hasRole('system_admin') || $user->hasRole('studio_admin');
        $isOwner = $booking->user_id === $user->id;

        if (!$isAdmin && !$isOwner) {
            return response()->json(['error' => 'У вас нет прав для редактирования'], 403);
        }

        // Валидация
        $request->validate([
            'data_type_id' => 'sometimes|exists:data_types,id',
            'description' => 'nullable|string',
            'recording_start_date' => 'sometimes|date',
            'end_date_of_recording' => 'required|date|after_or_equal:recording_start_date',
            'status' => 'sometimes|string',
        ]);

        $updateData = [];

        if ($isOwner && !$isAdmin) {
            // Владелец может менять все, кроме статуса
            if ($request->has('data_type_id')) {
                $updateData['data_type_id'] = $request->data_type_id;
            }
            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }
            if ($request->has('recording_start_date')) {
                $updateData['recording_start_date'] = $request->recording_start_date;
            }
            if ($request->has('end_date_of_recording')) {
                $updateData['end_date_of_recording'] = $request->end_date_of_recording;
            }
            // Статус НЕ меняем
        }

        if ($isAdmin && !$isOwner) {
            // Админ может менять только статус
            if ($request->has('status')) {
                $updateData['status'] = $request->status;
            }
            // Остальные поля НЕ меняем
        }

        // В случае, если пользователь и админ — например, если админ сам владелец брони,
        // можно либо разрешить полный доступ, либо ограничить
        // Здесь можно добавить логику, если нужно

        if (empty($updateData)) {
            return response()->json(['error' => 'Нет данных для обновления или недостаточно прав'], 400);
        }

        $booking->update($updateData);

        $booking->load(['user', 'dataType']);

        return response()->json([
            'message' => 'Бронь успешно обновлена',
            'booking' => $booking,
        ]);
    }

    // Удаляет бронь полностью для администраторов или меняет статус на "cancelled" для владельца брони.
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        $isAdmin = $user->hasRole(['system_admin', 'studio_admin']);
        $isOwner = $booking->user_id === $user->id;

        if ($isAdmin) {
            $booking->delete();
            return response()->json(['message' => 'Бронь успешно удалена администратором']);
        }

        if ($isOwner) {
            $booking->status = 'cancelled';
            $booking->save();

            // Если нужно вернуть обновлённую бронь:
            $booking->load(['user', 'dataType']);
            return response()->json(['message' => 'Бронь успешно отменена']);
        }

        return response()->json(['error' => 'У вас нет прав для удаления'], 403);
    }
}
