<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Получить все галереи
    public function index()
    {
        return Gallery::all();
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

