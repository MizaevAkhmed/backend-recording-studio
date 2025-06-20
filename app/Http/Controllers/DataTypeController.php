<?php

namespace App\Http\Controllers;

use App\Models\DataType;
use Illuminate\Http\Request;

class DataTypeController extends Controller
{
    // Получение списка всех категорий
    public function index()
    {
        return response()->json(DataType::orderBy('created_at', 'desc')->get());
    }

    // Создание новой категории
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $dataType = DataType::create($validated);

        return response()->json($dataType, 201);
    }

    // Обновление существующей категории
    public function update(Request $request, $id)
    {
        $dataType = DataType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $dataType->update($validated);

        return response()->json($dataType);
    }

    // Удаление категории
    public function destroy($id)
    {
        $dataType = DataType::findOrFail($id);
        $dataType->delete();

        return response()->json(['message' => 'Категория удалена.']);
    }
}
