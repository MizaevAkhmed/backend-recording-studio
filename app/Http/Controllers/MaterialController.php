<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Material;
use App\Models\Article;
use App\Models\Podcast;
use App\Models\Video;
use App\Models\Category;

class MaterialController extends Controller
{
    // Получение списка всех материалов
    public function index()
    {
        $materials = Material::with('materialable')->get();
        return response()->json($materials);
    }

    // Получение списка материалов с категориями
    public function getMaterialsWithCategories() {
        // Фиксированные категории (1, 2, 3)
        $categoryIds = [1, 2, 3];

        // Получаем категории для отображения
        $categories = Category::whereIn('id', $categoryIds)->get();

        // Получаем материалы, которые относятся к этим категориям
        $materials = Material::with('materialable')  // Загружаем связанные данные
            ->whereIn('category_id', $categoryIds)
            ->get();
        
        // Возвращаем данные в одном ответе
        return response()->json([
            'categories' => $categories,
            'materials' => $materials
        ]);
    }    

    // Создание нового материала
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:article,podcast,video',
            'file_path' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Определяем, какой тип материала создаем
        $materialable = null;

        if ($request->type === 'article') {
            $materialable = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'file_path' => $request->file_path,
                'description' => $request->description,
            ]);
        } elseif ($request->type === 'podcast') {
            $materialable = Podcast::create([
                'title' => $request->title,
                'file_path' => $request->file_path,
                'description' => $request->description,
            ]);
        } elseif ($request->type === 'video') {
            $materialable = Video::create([
                'title' => $request->title,
                'file_path' => $request->file_path,
            ]);
        }

        if ($materialable) {
            $material = Material::create([
                'user_id' => $user->id,
                'category_id' => $request->category_id,
                'materialable_id' => $materialable->id,
                'materialable_type' => get_class($materialable),
            ]);

            return response()->json($material->load('materialable'), 201);
        }

        return response()->json(['error' => 'Ошибка при создании материала'], 400);
    }

    // Получение одного материала
    public function show($id)
    {
        $material = Material::with('materialable')->findOrFail($id);
        return response()->json($material);
    }

    // Обновление материала (админ, автор материала)
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $user = auth()->user();

        // Только автор или админ может редактировать
        if ($user->id !== $material->user_id && $user->type_user !== 'admin') {
            return response()->json(['error' => 'Нет прав на редактирование'], 403);
        }

        $materialable = $material->materialable;

        if ($materialable) {
            $materialable->update($request->only(['title', 'description', 'file_path', 'content']));
        }

        $material->update($request->only(['category_id']));

        return response()->json($material->load('materialable'));
    }

    // Удаление материала (автор или админ).
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $user = auth()->user();

        // Только автор или админ может удалять
        if ($user->id !== $material->user_id && $user->type_user !== 'admin') {
            return response()->json(['error' => 'Нет прав на удаление'], 403);
        }

        $material->materialable->delete();
        $material->delete();

        return response()->json(['message' => 'Материал удален']);
    }
}
