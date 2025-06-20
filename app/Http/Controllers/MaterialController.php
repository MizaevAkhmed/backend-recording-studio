<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\DataType;

class MaterialController extends Controller
{
    public function getMaterialsAndCategories()
    {
        $categories = DataType::all();
        $materials = Material::with('dataType', 'user:id,firstname,name')->get();

        // Добавляем публичный URL к каждому материалу
        $materials->each(function ($material) {
            $material->file_url = $material->file_url;
        });

        return response()->json([
            'categories' => $categories,
            'materials' => $materials,
        ]);
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        $material->file_url = $material->file_url;

        return response()->json($material, 200);
    }

    public function store(Request $request)
    {
        if (!$request->user()->hasRole(['studio_admin', 'system_admin'])) {
            return response()->json(['error' => 'У вас нет прав для создания материала'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'data_type_id' => 'required|exists:data_types,id',
            'file' => 'nullable|file|max:512000|mimes:mp4,mov,avi,mkv,mp3,wav,aac,jpg,jpeg,png,webp',
            'external_link' => 'nullable|url',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
            $validated['file'] = $path;  // только относительный путь
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

        if (!$request->user()->hasRole(['studio_admin', 'system_admin']) && $request->user()->id !== $material->user_id) {
            return response()->json(['error' => 'У вас нет доступа'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'data_type_id' => 'required|exists:data_types,id',
            'file' => 'nullable|file|max:512000|mimes:mp4,mov,avi,mkv,mp3,wav,aac,jpg,jpeg,png,webp',
            'external_link' => 'nullable|url',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
            $validated['file'] = $path;  // только относительный путь
        } elseif ($request->filled('external_link')) {
            $validated['file'] = $request->input('external_link');
        }

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

        if (!$request->user()->hasRole(['studio_admin', 'system_admin']) && $request->user()->id !== $material->user_id) {
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
