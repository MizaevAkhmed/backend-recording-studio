<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        // Добавляем ссылку на фото профиля
        $user->photo_profile_url = $user->photo_profile
            ? asset('storage/' . $user->photo_profile)
            : null;

        return response()->json($user);
    }

    // Получение всех пользователей (только админ)
    public function index()
    {
        if (!Auth::user()->hasRole(['system_admin'])) {
            return response()->json(['message' => 'У вас нет доступа'], 403);
        }

        return response()->json(User::all());
    }

    // Получение одного пользователя (только админ)
    public function show($id)
    {
        if (!Auth::user()->hasRole(['system_admin'])) {
            return response()->json(['message' => 'У вас нет доступа'], 403);
        }

        return response()->json(User::findOrFail($id));
    }

    // Создание нового пользователя (только админ)
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole(['system_admin'])) {
            return response()->json(['message' => 'У вас нет доступа'], 403);
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'type_user' => ['sometimes', Rule::in(['student', 'teacher', 'admin'])],
            'photo_profile' => 'nullable|file|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_profile')) {
            $photoPath = $request->file('photo_profile')->store('profile_photos', 'public');
        }

        $user = User::create([
            'firstname' => $validated['firstname'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'type_user' => $validated['type_user'] ?? 'student',
            'photo_profile' => $photoPath,
        ]);

        return response()->json($user, 201);
    }

    // Обновление пользователя (админ или сам пользователь)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!Auth::user()->hasRole(['system_admin']) && Auth::id() !== $user->id) {
            return response()->json(['message' => 'У вас нет доступа'], 403);
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo_profile' => 'nullable|file|image|max:2048',
            'type_user' => ['sometimes', Rule::in(['student', 'teacher', 'admin'])],
            'old_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->hasFile('photo_profile')) {
            if ($user->photo_profile) {
                Storage::disk('public')->delete($user->photo_profile);
            }
            $user->photo_profile = $request->file('photo_profile')->store('profile_photos', 'public');
        }

        $user->firstname = $validated['firstname'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (Auth::user()->hasRole(['system_admin']) && isset($validated['type_user'])) {
            $user->type_user = $validated['type_user'];
        }

        if (!empty($validated['new_password'])) {
            if (!Auth::user()->hasRole(['system_admin'])) {
                if (empty($validated['old_password']) || !Hash::check($validated['old_password'], $user->password)) {
                    throw ValidationException::withMessages([
                        'old_password' => ['Старый пароль неверен.'],
                    ]);
                }
            }
            $user->password = bcrypt($validated['new_password']);
        }

        $user->save();

        // Добавим ссылку на фото для удобства фронтенда
        $user->photo_profile_url = $user->photo_profile
            ? asset('storage/' . $user->photo_profile)
            : null;

        return response()->json($user, 200);
    }

    // Удаление пользователя (только админ)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (!Auth::user()->hasRole(['system_admin'])) {
            return response()->json(['message' => 'У вас нет доступа'], 403);
        }

        if ($user->photo_profile) {
            Storage::disk('public')->delete($user->photo_profile);
        }

        $user->delete();

        return response()->json(['message' => 'Пользователь успешно удален']);
    }
}
