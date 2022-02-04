<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::orderBy('id', 'desc')->get();
        //dd($categories);
        return view('admin.categories.index',  compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        Category::create($request->all());
        return back();
    }
}
