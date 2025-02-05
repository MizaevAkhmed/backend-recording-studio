<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Получение всех пользователей (только админ)
    public function index()
    {
        // Проверка, что пользователь является администратором
        if (Auth::user()->type_user != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(User::all());
    }

    // Получение одного пользователя
    public function show($id)
    {
        // Пользователь может просматривать только свой профиль, админ — любой
        if (Auth::id() != $id && Auth::user()->type_user != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(User::findOrFail($id));
    }

    // Создание нового пользователя (только админ)
    public function store(Request $request)
    {
        // Проверка, что пользователь является администратором
        if (Auth::user()->type_user != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type_user' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'type_user' => $validated['type_user'],
        ]);

        return response()->json($user, 201);
    }

    // Обновление пользователя
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Пользователь может обновить только свой профиль, админ — любой
        if (Auth::id() != $id && Auth::user()->type_user != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->update($request->all());
        return response()->json($user);
    }

    // Удаление пользователя
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Пользователь может удалить только свой профиль, админ — любой
        if (Auth::id() != $id && Auth::user()->type_user != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}