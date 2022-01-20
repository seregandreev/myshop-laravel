<?php

use App\Models\Category;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
Artisan::command('massInsert', function () {
    $categories = [
        [
            'name' => 'Видеокарты',
            'description' => 'Описание категории Видеокарты'
        ],
        [
            'name' => 'Процессоры',
            'description' => 'Описание категории Процессоры'
        ],
    ];
    Category::insert($categories);
});

Artisan::command('updateCategory', function () {
    Category::where('id', 2)->update([
        'name' => 'Видеокарты!'
    ]);
});

Artisan::command('deleteCategory', function () {
    $category = Category::find(2);
    $category->delete();
});

Artisan::command('createCategory', function () {
    $category = new Category([
        'name' => 'Видеокарты',
        'description' => 'Описание категории Видеокарты'
    ]);
    $category->save();
});

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
