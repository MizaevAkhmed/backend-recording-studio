<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\DataType;

class MaterialController extends Controller
{
    public function getMaterialsAndCategories()
    {
        $categories = DataType::all(); // категории материалов (типы данных)
        $materials = Material::with('dataType')->get(); // материалы с подгруженной категорией

        return response()->json([
            'categories' => $categories,
            'materials' => $materials,
        ]);
    }

    public function index()
    {
        return Material::all();
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);

        if (!$material) {
            return response()->json(['error' => 'Материал не найден'], 404);
        }

        return response()->json($material, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'data_type_id' => 'required|exists:data_types,id',
            'file' => 'nullable|file|max:102400|mimes:mp4,mp3,avi,doc,docx,pdf',
            'external_link' => 'nullable|url',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
            $validated['file'] = 'storage/' . $path;
        } elseif ($request->filled('external_link')) {
            $validated['file'] = $request->input('external_link');
        } else {
            $validated['file'] = null;
        }

        unset($validated['external_link']);

        $material = Material::create($validated);

        return response()->json([
            'message' => 'Материал создан',
            'data' => $material
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        if (!$request->user()->isAdmin() && $request->user()->id !== $material->user_id) {
            return response()->json(['error' => 'У вас нет доступа'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'data_type_id' => 'required|exists:data_types,id',
            'file' => 'nullable|file|max:102400|mimes:mp4,mp3,avi,doc,docx,pdf',
            'external_link' => 'nullable|url',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
            $validated['file'] = 'storage/' . $path;
        } elseif ($request->filled('external_link')) {
            $validated['file'] = $request->input('external_link');
        } // иначе не трогаем старое значение

        unset($validated['external_link']);

        $material->update($validated);

        return response()->json([
            'data' => $material,
            'message' => 'Материал успешно обновлён'
        ], 200);
    }


    public function destroy(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        // Проверка прав: только админ или автор может удалить
        if (!$request->user()->isAdmin() && $request->user()->id !== $material->user_id) {
            return response()->json([
                'error' => 'У вас нет прав для удаления этого материала'
            ], 403);
        }

        $material->delete();

        return response()->json([
            'message' => 'Материал успешно удален'
        ], 200);
    }
}
