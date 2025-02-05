<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Получение всех уведомлений
    public function index()
    {
        return Notification::all();
    }

    // Получение одного уведомления
    public function show($id)
    {
        return Notification::findOrFail($id);
    }

    // Создание уведомления
    public function store(Request $request)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $notification = Notification::create($request->all());
        return response()->json($notification, 201);
    }

    // Обновление уведомления
    public function update(Request $request, $id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $notification = Notification::findOrFail($id);
        $notification->update($request->all());
        return response()->json($notification);
    }

    // Удаление уведомления
    public function destroy($id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json(['message' => 'Удалено успешно']);
    }
}


