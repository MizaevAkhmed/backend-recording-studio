<?php

namespace App\Http\Controllers;

use App\Models\NonworkingDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NonworkingDaysController extends Controller
{
    // Проверка на право управление нерабочими днями (праздниками)
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        // Только system_admin может выполнять все действия
        $this->middleware(function ($request, $next) {
            if (auth()->user()?->type_user !== 'system_admin') {
                return response()->json(['message' => 'Доступ запрещён'], 403);
            }
            return $next($request);
        });
    }
    // Получить список нерабочих дней
    public function index()
    {
        return NonworkingDay::orderBy('date', 'asc')->get();
    }

    // Добавить новый нерабочий день
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|unique:nonworking_days,date',
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
            ], 422);
        }

        $day = NonworkingDay::create([
            'date' => $request->date,
            'reason' => $request->reason,
        ]);

        return response()->json($day, 201);
    }

    // Обновить существующий нерабочий день
    public function update(Request $request, $id)
    {
        $day = NonworkingDay::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date|unique:nonworking_days,date,' . $id,
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
            ], 422);
        }

        $day->update([
            'date' => $request->date,
            'reason' => $request->reason,
        ]);

        return response()->json($day);
    }

    // Удалить нерабочий день
    public function destroy($id)
    {
        $day = NonworkingDay::findOrFail($id);
        $day->delete();

        return response()->json(['message' => 'Праздник удалён']);
    }
}
