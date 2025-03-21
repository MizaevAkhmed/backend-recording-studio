<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Регистрация пользователя
    public function register(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'photo_profile' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Создание нового пользователя
        $user = User::create([
            'firstname' => $validated['firstname'],
            'name' => $validated['name'],
            'photo_profile' => $validated['photo_profile'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student', // по умолчанию роль студента
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Авторизация пользователя
    public function login(Request $request)
    {
        // Валидация входных данных
        $credentials = $request->only('email', 'password');

        // Проверка наличия пользователя с такими данными
        if (!Auth::attempt($credentials)) {
            // Возвращаем ошибку если авторизация не удалась
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        $user = Auth::user();

        // Создание токена для пользователя
        $token = $user->createToken('YourApp')->plainTextToken;

        // Возвращаем ответ с токеном
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user, // Информация о пользователе
        ]);
    }
}