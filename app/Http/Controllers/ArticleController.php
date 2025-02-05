<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Получить все статьи
    public function index()
    {
        // Получить все статьи
        return Material::where('category_id', 1)->get(); // Пример для статей
    }

    // Получить одну статью
    public function store(Request $request)
    {
        // Для пользователя или администратора
        $article = Material::create($request->all());
        return response()->json($article, 201);
    }

    // Обновить статью
    public function update(Request $request, $id)
    {
        $article = Material::findOrFail($id);

        // Только для владельца материала или администратора
        if (auth()->user()->id !== $article->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $article->update($request->all());
        return response()->json($article);
    }

    // Удалить статью
    public function destroy($id)
    {
        $article = Material::findOrFail($id);

        // Только для владельца материала или администратора
        if (auth()->user()->id !== $article->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $article->delete();
        return response()->json(['message' => 'Удалено успешно']);
    }
}


