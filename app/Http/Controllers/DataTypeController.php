<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataType;
use Illuminate\Http\Request;

class DataTypeController extends Controller
{
    public function index()
    {
        return DataType::all();
    }

    public function show($id)
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy(Request $request, $id)
    {
        
    }
}
