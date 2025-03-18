<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class BookingController extends Controller
{
    // Получение всех бронирований для администратора или текущего пользователя
    public function index()
    {
        if(Auth::user()->user_id = 3){
            $bookings = Booking::all(); // Администратор получает все бронирования
        }else{
            $bookings = Booking::where('user_id', Auth::id())->get(); // Пользователь получает только свои
        }

        return response()->json($bookings);
    }

    // Просмотр конкретного бронирования
    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        if (!$booking) {
            return response()->json(['error' => 'Бронь не найдена'], 404);
        }

        return response()->json($booking, 200);
    }

    // Создание нового бронирования
    public function store(Request $request)
    {
        $request->validate([
            'data_type_id' => 'required|exists:data_types,id',
            'description' => 'nullable|string',
            'recording_start_date' => 'required|date',
            'end_date_of_recording' => 'required|date',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'data_types_id' => $request->data_type_id,
            'description' => $request->description,
            'recording_start_date' => $request->recording_start_date,
            'end_date_of_recording' => $request->end_date_of_recording,
            'status' => 'booked'
        ]);
        
        return response()->json([
            'message' => 'Бронь успешно создана',
            'booking' => $booking
        ]);
    }

    // Обновление бронирования
    public function update(Request $request, Booking $booking)
    {

        if($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()){
            return response()->json([
                'error' => 'у вас нет прав для редактирования', 403
            ]);
        }

        $request->update([
            'data_types_id' => $request->data_type_id ?? $booking->data_type_id,
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
        //
    }

    // Получение массива с типами данных для бронирования
    public function getDataTypes()
    {
        $dataTypes = DataType::all();
        return response()->json($dataTypes);
    }
}
