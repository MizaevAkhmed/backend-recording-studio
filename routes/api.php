<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\TypeNotificationController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Публичные маршруты (доступны всем)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/materials', [MaterialController::class, 'index']); // Получить все материалы
Route::get('/articles', [ArticleController::class, 'index']); // Получить все статьи
Route::get('/podcasts', [PodcastController::class, 'index']); // Получить все подкасты
Route::get('/videos', [VideoController::class, 'index']); // Получить все видео
Route::get('/articles/{id}', [ArticleController::class, 'show']); // Получить одну статью
Route::get('/podcasts/{id}', [PodcastController::class, 'show']); // Получить один подкаст
Route::get('/videos/{id}', [VideoController::class, 'show']); // Получить одно видео

// Защищенные маршруты (только для аутентифицированных пользователей)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Материалы - только для авторизованных пользователей
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->middleware('can:update,article');

    Route::post('/podcasts', [PodcastController::class, 'store']);
    Route::put('/podcasts/{id}', [PodcastController::class, 'update']);
    Route::delete('/podcasts/{id}', [PodcastController::class, 'destroy'])->middleware('can:update,podcast');

    Route::post('/videos', [VideoController::class, 'store']);
    Route::put('/videos/{id}', [VideoController::class, 'update']);
    Route::delete('/videos/{id}', [VideoController::class, 'destroy'])->middleware('can:update,video');
});

// Админские маршруты (только для администраторов)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Управление пользователями (только для админа)
    Route::get('/admin/users', [AdminController::class, 'getUsers']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);

    // Управление всеми материалами (для админа)
    Route::resource('/admin/articles', ArticleController::class);
    Route::resource('/admin/podcasts', PodcastController::class);
    Route::resource('/admin/videos', VideoController::class);
});
