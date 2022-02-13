<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products', [AdminController::class, 'products'])->name('adminProducts');
    //Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');   
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    Route::post('/exportCategories', [AdminController::class, 'exportCategories'])->name('exportCategories');
    Route::post('/importCategories', [AdminController::class, 'importCategories'])->name('importCategories');
    
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    //Route::resource('categories', CategoryController::class);
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store',  [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit',  [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/{id}/update',  [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/{id}/delete',  [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store',  [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit',  [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/{id}/update',  [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/{id}/delete',  [ProductController::class, 'delete'])->name('product.delete');

    Route::prefix('roles')->group(function() {
        Route::post('/add', [AdminController::class, 'addRole'])->name('addRole');
        Route::get('/delete{id}', [AdminController::class, 'deleteRole'])->name('deleteRole');
        Route::post('/addRoleToUser', [AdminController::class, 'addRoleToUser'])->name('addRoleToUser');
    });
});

Route::prefix('cart')->group(function() {
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('/removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
});

Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/save', [ProfileController::class, 'save'])->name('saveProfile');


Auth::routes();



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
