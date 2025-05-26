<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Получение всех новостей вместе с категориями
    public function getNewsAndCategories()
    {
        // Получаем категории
        $categories = NewsCategory::all();

        // Получаем новости с фотографиями и категориями
        $news = News::with('photos')->get();

        return response()->json([
            'categories' => $categories,
            'news' => $news,
        ]);
    }

    // Получение всех новостей
    public function index()
    {
        return News::with('photos:id,news_id,path')
            ->select('id', 'title', 'content', 'date', 'location', 'category_id')
            ->get();
    }

    // Получение одной новости
    public function show($id)
    {
        // Подгружаем связанные категории и фото
        return News::with(['category', 'photos'])->findOrFail($id);
    }

    // Создание новости
    public function store(Request $request)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:news_categories,id', // Категория должна существовать
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // Ограничение на фото
        ]);

        // Создание новости
        $news = News::create($validated);

        // Загрузка и сохранение фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Сохранение файла в директории 'news_photos'
                $path = $file->store('uploads/news_photos', 'public');
                // Создание связи с фото
                $news->photos()->create(['path' => $path]);
            }
        }

        return response()->json($news, 201);
    }

    // Обновление новости
    public function update(Request $request, $id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:news_categories,id', // Категория должна существовать
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // Ограничение на фото
        ]);

        $news = News::findOrFail($id);
        $news->update($validated);

        // Загрузка новых фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Сохранение фото в директории 'news_photos'
                $path = $file->store('news_photos', 'public');
                // Создание связи с фото
                $news->photos()->create(['path' => $path]);
            }
        }

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

        // Удаление фото при удалении новости
        foreach ($news->photos as $photo) {
            Storage::delete('public/' . $photo->path); // Удаляем фото с сервера
            $photo->delete(); // Удаляем запись в базе данных
        }

        $news->delete(); // Удаление новости

        return response()->json(['message' => 'Удалено успешно']);
    }
}