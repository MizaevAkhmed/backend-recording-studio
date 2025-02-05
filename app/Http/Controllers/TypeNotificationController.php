<?php

namespace App\Http\Controllers;

use App\Models\TypeNotification;
use Illuminate\Http\Request;

class TypeNotificationController extends Controller
{
    // Получение всех типов уведомлений
    public function index()
    {
        return response()->json(TypeNotification::all());
    }

    // Создание нового типа уведомления
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeNotification = TypeNotification::create($validated);
        return response()->json($typeNotification, 201);
    }

    // Обновление типа уведомления
    public function update(Request $request, $id)
    {
        $typeNotification = TypeNotification::findOrFail($id);
        $typeNotification->update($request->all());
        return response()->json($typeNotification);
    }

    // Удаление типа уведомления
    public function destroy($id)
    {
        $typeNotification = TypeNotification::findOrFail($id);
        $typeNotification->delete();
        return response()->json(['message' => 'TypeNotification deleted']);
    }
}
