<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DataTypeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NewsController;
use App\Http\Controller\NewsCategoryController;
use App\Http\Controllers\NonworkingDaysController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TypeNotificationController;
use App\Http\Controllers\UserController;

// Публичные маршруты (доступны всем)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/news', [NewsController::class, 'index']); // Получить все новости
Route::get('/news-categories', [NewsCategoryController::class, 'index']); // Получить все категории для новостей

// Защищенные маршруты (только для аутентифицированных пользователей)
Route::middleware(['auth:sanctum'])->group(function () {
    // Профиль пользователя
    Route::get('/profile/{id}', [UserController::class, 'show']);
    Route::put('/profile/{id}', [UserController::class, 'update']);
    Route::delete('/profile/{id}', [UserController::class, 'delete']);

    // Выйти из учетной записи
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Бронирование студии
    Route::get('/booking', [BookingController::class, 'index']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::put('/booking/{id}', [BookingController::class, 'update']);
    Route::get('/getBookingData', [BookingController::class, 'getBookingData']); // Получение праздников и забронированных дней для отображения их в календаре при бронировании

    // Материалы
    Route::post('/materials', [MaterialController::class, 'store']);
    Route::put('/materials/{id}', [MaterialController::class, 'update']);
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);
    Route::get('/materials-with-data-types', [MaterialController::class, 'getMaterialsWithDataTypes']); // Получение сортированного списка материалов с типами данных

    // Профиль пользователя
    Route::get('/users/{id}', [UserController::class, 'index']);
    Route::put('/users/{id}', [UserController::class, 'update']);
});

// Админские маршруты (только для администраторов)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Пользователи
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Типы данных используемых для сортировки материалов и для указания типа данных при бронировании 
    Route::get('/data-types', [DataTypeController::class, 'index']);
    Route::post('/data-types', [DataTypeController::class, 'store']);
    Route::put('/data-types/{id}', [DataTypeController::class, 'update']);
    Route::delete('/data-types/{id}', [DataTypeController::class, 'destroy']);

    // Бронирование студии
    Route::get('/booking', [BookingController::class, 'index']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::put('/booking/{id}', [BookingController::class, 'update']);
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']);

    // Выходные дни в календаре
    Route::get('/nonworking-days', [NonworkingDaysController::class, 'index']);
    Route::post('/nonworking-days', [NonworkingDaysController::class, 'store']);
    Route::put('/nonworking-days/{id}', [NonworkingDaysController::class, 'update']);
    Route::delete('/nonworking-days/{id}', [NonworkingDaysController::class, 'destroy']);

    // Новости
    Route::get('/news', [NewsController::class, 'index']);
    Route::post('/news', [NewsController::class, 'store']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);

    // Материалы
    Route::get('/materials', [MaterialController::class, 'index']);
    Route::post('/materials', [MaterialController::class, 'store']);
    Route::put('/materials/{id}', [MaterialController::class, 'update']);
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);

    // Уведомления
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::put('/notifications/{id}', [NotificationController::class, 'update']);    
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // Типы уведомлений
    Route::get('/type-notifications', [TypeNotificationController::class, 'index']);
    Route::post('/type-notifications', [TypeNotificationController::class, 'store']);
    Route::put('/type-notifications/{id}', [TypeNotificationController::class, 'update']);
    Route::delete('/type-notifications/{id}', [TypeNotificationController::class, 'destroy']);
});
