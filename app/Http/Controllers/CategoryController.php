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
        $categories = Category::create($request->all());

        $input = request()->all();
        $picture = $input['picture'] ?? null;
        request()->validate([
            'name' => 'required',
            'picture' => 'mimetypes:image/*'
        ]);

        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/categories', $fileName);
            $categories->picture = "categories/$fileName";
        }

        return redirect()
            ->to(route('admin.categories.create'));
    }

    public function edit()
    {
        return view('admin.categories.edit');
    }

    public function update(Request $request)
    {
        $categories = Category::create($request->all());

        $input = request()->all();
        $picture = $input['picture'] ?? null;
        request()->validate([
            'name' => 'required',
            'picture' => 'mimetypes:image/*'
        ]);
        
        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/categories', $fileName);
            $categories->picture = "categories/$fileName";
        }

        return redirect()
            ->to(route('admin.categories.create'));
    }
}
