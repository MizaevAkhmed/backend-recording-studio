<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
        $validated = $request->validate([
            'data_type_id' =>'required|exists:data_types,id',
            'description' => 'nullable|string',
            'recording_start_date' => 'required|date',
            'end_date_of_recording' => 'required|date'
        ]);
    }

    // Обновление бронирования
    public function update(Request $request, $id)
    {
        //
    }

    // Удаление бронирования
    public function destroy($id)
    {
        //
    }
}
