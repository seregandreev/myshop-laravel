<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.index',  compact('products'));
    }

    public function create()
    {   
        $categories = Category::get();
        return view('admin.products.create',  compact('categories'));
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        $input = request()->all();
        $picture = $input['picture'] ?? null;
        request()->validate([
            'name' => 'required',
            'picture' => 'mimetypes:image/*'
        ]);

        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/products', $fileName);
            $product->picture = "products/$fileName";
            $product->save();
        }

        session()->flash('saveProduct');
        return redirect()
            ->to(route('product.create'));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get();
        return view('admin.products.edit',  compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        $input = request()->all();
        $picture = $input['picture'] ?? null;
        request()->validate([
            'name' => 'required',
            'picture' => 'nullable|mimetypes:image/*'
        ]);
       
        if($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/products', $fileName);
            $product->picture = "products/$fileName";
            $product->save();
        }

        return redirect()
            ->to(route('products.index'));
    }

    public function delete ($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()
        ->to(route('products.index'));
    }
}
