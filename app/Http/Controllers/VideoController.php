<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // Получение всех видео
    public function index()
    {
        return response()->json(Material::where('type', 'video')->get());
    }

    // Получение одного видео
    public function show($id)
    {
        return response()->json(Material::findOrFail($id));
    }

    // Создание нового видео
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $video = Material::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->user()->id,
            'type' => 'video',
        ]);

        return response()->json($video, 201);
    }

    // Обновление видео
    public function update(Request $request, $id)
    {
        $video = Material::findOrFail($id);

        if ($video->user_id !== auth()->user()->id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $video->update($request->all());
        return response()->json($video);
    }

    // Удаление видео
    public function destroy($id)
    {
        $video = Material::findOrFail($id);

        if ($video->user_id !== auth()->user()->id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $video->delete();
        return response()->json(['message' => 'Video deleted']);
    }
}

