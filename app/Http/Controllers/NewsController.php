<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Получение всех новостей вместе с категориями и фото с url
    public function getNewsAndCategories()
    {
        $categories = NewsCategory::all();
        $news = News::with(['photos', 'category'])->get();

        // Добавим url для каждого фото
        $news->each(function ($item) {
            $item->photos->each(function ($photo) {
                $photo->url = $photo->path ? asset('storage/' . $photo->path) : null;
            });
        });

        return response()->json([
            'categories' => $categories,
            'news' => $news,
        ]);
    }

    // Получение одной новости с фото и категорией
    public function show($id)
    {
        $news = News::with(['photos', 'category'])->findOrFail($id);

        $news->photos->each(function ($photo) {
            $photo->url = $photo->path ? asset('storage/' . $photo->path) : null;
        });

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

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if ($file) {
                    $path = $file->store('news-photos', 'public');
                    $news->photos()->create(['path' => $path]);
                }
            }
        }

        // Добавим url к фото для ответа
        $news->load('photos', 'category');
        $news->photos->each(function ($photo) {
            $photo->url = $photo->path ? asset('storage/' . $photo->path) : null;
        });

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

        if ($request->has('deleted_photo_ids')) {
            foreach ($request->deleted_photo_ids as $photoId) {
                $photo = $news->photos()->find($photoId);
                if ($photo) {
                    Storage::disk('public')->delete($photo->path);
                    $photo->delete();
                }
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if ($file) {
                    $path = $file->store('news-photos', 'public');
                    $news->photos()->create(['path' => $path]);
                }
            }
        }

        $news->load('photos', 'category');
        $news->photos->each(function ($photo) {
            $photo->url = $photo->path ? asset('storage/' . $photo->path) : null;
        });

        return response()->json($news);
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
