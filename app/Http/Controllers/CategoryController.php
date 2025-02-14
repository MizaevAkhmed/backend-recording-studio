<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Получить все категории
    public function index()
    {
        return Category::all();
    }
    
    // Получить одну категорию
    public function store(Request $request)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    // Обновить категорию
    public function update(Request $request, $id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json($category);
    }

    // Удалить категорию
    public function destroy($id)
    {
        // Только для администратора
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Удалено успешно']);
    }
}


