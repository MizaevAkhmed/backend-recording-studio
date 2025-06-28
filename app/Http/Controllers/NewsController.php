<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Получение всех новостей вместе с категориями и фото
    public function getNewsAndCategories()
    {
        $categories = NewsCategory::all();
        $news = News::with('photos')->get();

        return response()->json([
            'categories' => $categories,
            'news' => $news,
        ]);
    }

    // Получение одной новости с фото и категорией
    public function show($id)
    {
        $news = News::with(['photos', 'category'])->findOrFail($id);

        return response()->json($news);
    }

    // Создание новости (только для system_admin)
    public function store(Request $request)
    {
        if ($request->user()->type_user !== 'system_admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:news_categories,id',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $news = News::create($validated);

        // Загрузка фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('news-photos', 'public');
                $news->photos()->create(['path' => $path]);
            }
        }

        return response()->json($news, 201);
    }

    // Обновление новости (только для system_admin)
    public function update(Request $request, $id)
    {
        if ($request->user()->type_user !== 'system_admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:news_categories,id',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'deleted_photo_ids' => 'array',
            'deleted_photo_ids.*' => 'integer|exists:news_photos,id',
        ]);

        $news = News::findOrFail($id);
        $news->update($validated);

        // Удаление отдельных фото
        if ($request->has('deleted_photo_ids')) {
            foreach ($request->deleted_photo_ids as $photoId) {
                $photo = $news->photos()->find($photoId);
                if ($photo) {
                    Storage::disk('public')->delete($photo->path);
                    $photo->delete();
                }
            }
        }

        // Добавление новых фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('news-photos', 'public');
                $news->photos()->create(['path' => $path]);
            }
        }

        return response()->json($news->load('photos', 'category'));
    }

    // Удаление новости (только для system_admin)
    public function destroy(Request $request, $id)
    {
        if ($request->user()->type_user !== 'system_admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $news = News::with('photos')->findOrFail($id);

        foreach ($news->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $news->delete();

        return response()->json(['message' => 'Новость успешно удалена']);
    }
}
