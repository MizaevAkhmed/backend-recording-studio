<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Получить все галереи
    public function index()
    {
        return Gallery::all();
    }

    // Получение данных из галереи с категориями
    public function getGaleryWithCategories(Request $request) {
        // Получаем категории для отображения
        $categories = Category::whereIn('id', [4, 5])->get();  // Отбираем категории 4-5
        
        // Получаем материалы, которые относятся к этим категориям
        $galleries = Gallery::with('materialable') // Загружаем связанные данные
            ->whereIn('category_id', [4, 5])
            ->get();
        
        // Возвращаем данные в одном ответе
        return response()->json([
            'categories' => $categories,
            'galleries' => $galleries
        ]);
    }   

    // Получить одну галерею
    public function show($id)
    {
        return Gallery::findOrFail($id);
    }

    // Создать галерею
    public function store(Request $request)
    {
        $galleryItem = Gallery::create($request->all());
        return response()->json($galleryItem, 201);
    }

    // Обновить галерею
    public function update(Request $request, $id)
    {
        $galleryItem = Gallery::findOrFail($id);

        // Только для владельца или администратора
        if (auth()->user()->id !== $galleryItem->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $galleryItem->update($request->all());
        return response()->json($galleryItem);
    }

    // Удалить галерею
    public function destroy($id)
    {
        $galleryItem = Gallery::findOrFail($id);

        // Только для владельца или администратора
        if (auth()->user()->id !== $galleryItem->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $galleryItem->delete();
        return response()->json(['message' => 'Удалено успешно']);
    }
}

