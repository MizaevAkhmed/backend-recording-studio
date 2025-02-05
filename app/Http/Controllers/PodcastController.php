<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    // Получение всех подкастов
    public function index()
    {
        return response()->json(Material::where('type', 'podcast')->get());
    }

    // Получение одного подкаста
    public function show($id)
    {
        return response()->json(Material::findOrFail($id));
    }

    // Создание нового подкаста
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $podcast = Material::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->user()->id,
            'type' => 'podcast',
        ]);

        return response()->json($podcast, 201);
    }

    // Обновление подкаста
    public function update(Request $request, $id)
    {
        $podcast = Material::findOrFail($id);

        if ($podcast->user_id !== auth()->user()->id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $podcast->update($request->all());
        return response()->json($podcast);
    }

    // Удаление подкаста
    public function destroy($id)
    {
        $podcast = Material::findOrFail($id);

        if ($podcast->user_id !== auth()->user()->id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $podcast->delete();
        return response()->json(['message' => 'Podcast deleted']);
    }
}