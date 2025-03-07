<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Получение всех уведомлений
    public function index()
    {
        $notification = Notification::all();
        return response()->json($notification, 200);
    }

    // Получение одного уведомления
    public function show($id)
    {
        return Notification::findOrFail($id);
    }

    // Создание уведомления
    public function store(Request $request)
    {
        
    }

    // Обновление уведомления
    public function update(Request $request, $id)
    {
        
    }

    // Удаление уведомления
    public function destroy($id)
    {

    }
}


