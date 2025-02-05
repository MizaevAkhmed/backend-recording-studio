<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // Показать все материалы
    public function index()
    {
        return Material::all();
    }

    // Показать один материал
    public function show($id)
    {
        return Material::findOrFail($id);
    }

    // Создать материал
    public function store(Request $request)
    {
        $material = Material::create($request->all());
        return response()->json($material, 201);
    }

    // Обновить материал
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        // Только для владельца материала или администратора
        if (auth()->user()->id !== $material->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $material->update($request->all());
        return response()->json($material);
    }

    // Удалить материал
    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        // Только для владельца материала или администратора
        if (auth()->user()->id !== $material->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Нет доступа'], 403);
        }

        $material->delete();
        return response()->json(['message' => 'Удалено успешно']);
    }
}