<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Получение списка всех статей.
     */
    public function index()
    {
        return response()->json(Article::all());
    }

    /**
     * Получение статьи (открытие на отдельной странице).
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    /**
     * Редактирование новой статьи.
     */
    public function update(Request $request, $id)
    {
        // Находим статью по ID
        $article = Article::findOrFail($id);

        // Валидируем входные данные
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Валидируем изображение
        ]);

        // Если было загружено новое изображение, сохраняем его
        if ($request->hasFile('file')) {
            // Удаляем старое изображение, если оно было
            if ($article->file_path && file_exists(public_path($article->file_path))) {
                unlink(public_path($article->file_path));
            }

            // Сохраняем новое изображение
            $filePath = $request->file('file')->store('articles_images', 'public');
            $validated['file_path'] = $filePath;
        }

        // Обновляем статью
        $article->update($validated);

        return response()->json($article);
    }
}
