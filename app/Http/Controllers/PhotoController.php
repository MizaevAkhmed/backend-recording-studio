<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        return Photo::all();
    }

    // Получить одно фото
    public function show($id)
    {
        return Photo::findOrFail($id);
    }

    // Добавить фото
    public function store(Request $request)
    {
        // Проверяем, является ли пользователь администратором
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        // Валидация запроса
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Создание фото
        $PhotoItem = Photo::create($request->all());

        return response()->json($PhotoItem, 201);
    }

    // Обновить фото
    public function update(Request $request, $id)
    {
        // Проверяем, является ли пользователь администратором
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        // Находим фото
        $PhotoItem = Photo::findOrFail($id);

        // Валидация запроса
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Обновляем данные
        $PhotoItem->update($request->all());

        return response()->json($PhotoItem);
    }

    // Удалить фото
    public function destroy($id)
    {
        // Проверяем, является ли пользователь администратором
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $PhotoItem = Photo::findOrFail($id);
        $PhotoItem->delete();

        return response()->json(['message' => 'Удалено успешно']);
    }
}
