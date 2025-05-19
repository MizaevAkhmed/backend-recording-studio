<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    // Получение всех категорий
    public function index()
    {
        // Получаем все категории с нужными полями
        return NewsCategory::select('id', 'name')->get();
    }
}
