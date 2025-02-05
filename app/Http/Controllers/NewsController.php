<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Получение всех новостей
    public function index()
    {
        return News::all();
    }

    // Получение одной новости
    public function show($id)
    {
        return News::findOrFail($id);
    }

    // Создание новости 
    public function store(Request $request)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $news = News::create($request->all());
        return response()->json($news, 201);
    }

    // Обновление новости
    public function update(Request $request, $id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $news = News::findOrFail($id);
        $news->update($request->all());
        return response()->json($news);
    }

    // Удаление новости
    public function destroy($id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $news = News::findOrFail($id);
        $news->delete();
        return response()->json(['message' => 'Удалено успешно']);
    }
}

