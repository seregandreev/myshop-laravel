<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HistoryOrderController;
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
Route::get('/vue_test', [HomeController::class, 'vueTest'])->name('vueTest');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products', [AdminController::class, 'products'])->name('adminProducts');
    //Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');   
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    
    Route::post('/exportCategories', [AdminController::class, 'exportCategories'])->name('exportCategories');
    Route::post('/importCategories', [AdminController::class, 'importCategories'])->name('importCategories');
    Route::post('/saveImportCategoriesFile', [AdminController::class, 'saveImportCategoriesFile'])->name('saveImportCategoriesFile');
    Route::get('/deleteExportFile', [AdminController::class, 'deleteExportFile'])->name('deleteExportFile');
    Route::post('/downloadExportFile', [AdminController::class, 'downloadExportFile'])->name('downloadExportFile');
    Route::post('/downloadExportProductsFile', [AdminController::class, 'downloadExportProductsFile'])->name('downloadExportProductsFile');
    
    Route::post('/saveImportProductsFile', [AdminController::class, 'saveImportProductsFile'])->name('saveImportProductsFile');
    Route::post('/exportProducts', [AdminController::class, 'exportProducts'])->name('exportProducts');
    Route::post('/importProducts', [AdminController::class, 'importProducts'])->name('importProducts');
    
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    //Route::resource('categories', CategoryController::class);
    Route::prefix('category')->group(function() {
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store',  [CategoryController::class, 'store'])->name('category.store');
        Route::get('/{id}/edit',  [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/{id}/update',  [CategoryController::class, 'update'])->name('category.update');
        Route::get('/{id}/delete',  [CategoryController::class, 'delete'])->name('category.delete');
    });

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::prefix('product')->group(function() {
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store',  [ProductController::class, 'store'])->name('product.store');
        Route::get('/{id}/edit',  [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/{id}/update',  [ProductController::class, 'update'])->name('product.update');
        Route::get('/{id}/delete',  [ProductController::class, 'delete'])->name('product.delete');
    });

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
Route::get('/category/{category}/getProducts', [HomeController::class, 'getProducts']);
Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/save', [ProfileController::class, 'save'])->name('saveProfile');
Route::get('/profile/deleteAddress/{id}', [ProfileController::class, 'deleteAddress'])->name('deleteAddress');

Route::get('/history', [HistoryOrderController::class, 'index'])->name('historyOrder');
Route::post('/replayToCart', [HistoryOrderController::class, 'replayToCart'])->name('replayToCart');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
