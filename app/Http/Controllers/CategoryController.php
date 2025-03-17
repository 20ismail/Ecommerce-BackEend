<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);

        $category = Category::create($request->all());

        return response()->json(['message' => 'Category created successfully']);
    }

    public function getProducts($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return $category;
    }
}
