<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Получение всех пользователей (только админ)
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(User::all());
    }

    // Получение одного пользователя
    public function show($id)
    {
        if (Auth::id() != $id && !Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(User::findOrFail($id));
    }

    // Создание нового пользователя (только админ)
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'У вас нет доступа'], 403);
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'photo_profile' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'type_user' => ['sometimes', Rule::in(['student', 'teacher', 'admin'])], // Проверяем, если передано
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'name' => $validated['name'],
            'photo_profile' => $validated['photo_profile'] ?? null,
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'type_user' => $validated['type_user'] ?? 'student', // По умолчанию "student"
        ]);

        return response()->json($user, 201);
    }

    // Обновление пользователя
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() != $id && !Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'photo_profile' => 'nullable|string|max:255',
            'email' => ['required|string|email|max:255'],
            'password' => 'nullable|string|min:8', // Разрешаем оставить старый пароль
            'type_user' => ['sometimes', Rule::in(['student', 'teacher', 'admin'])], // Проверяем только если передано
        ]);

        $user->update([
            'firstname' => $validated['firstname'],
            'name' => $validated['name'],
            'photo_profile' => $validated['photo_profile'] ?? $user->photo_profile,
            'email' => $validated['email'],
            'password' => isset($validated['password']) ? bcrypt($validated['password']) : $user->password,
            'type_user' => $validated['type_user'] ?? $user->type_user, // Не менять, если не передано
        ]);

        return response()->json($user, 200);
    }

    // Удаление пользователя
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() != $id && !Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'Пользователь успешно удален']);
    }
}
