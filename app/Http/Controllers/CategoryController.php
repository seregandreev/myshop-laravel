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
        $category = Category::create($request->all());

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
            $category->picture = "categories/$fileName";
            $category->save();
        }

        session()->flash('saveCategory');
        return redirect()
            ->to(route('category.create'));
    }

    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit',  compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        $input = request()->all();
        $picture = $input['picture'] ?? null;
        request()->validate([
            'name' => 'required',
            'picture' => 'nullable|mimetypes:image/*'
        ]);
       
        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/categories', $fileName);
            $category->picture = "categories/$fileName";
            $category->save();
        }

        return redirect()
            ->to(route('categories.index'));
    }

    public function delete ($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()
        ->to(route('categories.index'));
    }
}
