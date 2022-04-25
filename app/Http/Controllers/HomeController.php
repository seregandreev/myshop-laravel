<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::get();
        return view('home', compact('categories'));
    }

    public function category ($category)
    {
        return view('category', compact('category'));
    }

    public function getProducts (Category $category) 
    {
        sleep(1);
        $products = $category->products;
        $products->transform(function ($product) {
            $product->quantity = session("cart.{$product->id}") ?? 0;
            return $product;
        });
        return $products;
    }

    public function vueTest()
    {
        return view('vue_test');
    }

    public function getCategories()
    {
        return Category::get();
    }
}
