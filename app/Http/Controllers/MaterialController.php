<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::all();
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        
        if (!$material){
            return response()->json(['error' => 'Материал не найден'], 404);
        }

        return response()->json($material, 200);
    }

    public function store(Request, $request)
    {
        $validated = $request->validate([
            'user_id' => 
        ])
    }
}
