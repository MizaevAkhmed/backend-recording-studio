<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::all();
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        
        if (!$material){
            return response()->json(['error' => 'Материал не найден'], 404);
        }

        return response()->json($material, 200);
    }

    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'data_type_id' => 'required|exists:data_types,id',
            'file_path' => 'nullable|string',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Добавляем ID текущего пользователя (автор записи)
        $validated['user_id'] = $request->user()->id;

        $material = Material::Create($validated);

        return response()->json([
            'message' => 'Материал создан',
            'data' => $material
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        // if()
    }

    public function destroy(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        
        
    }
}
