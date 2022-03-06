<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\XPath\XPathExpr;

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

Artisan::command('queryBuilder', function () {

    $data = DB::table('categories as c')
        ->select(
            'c.id',
            'c.name',
            'c.description'
        )
        ->where('name', 'Процессоры')
        ->first();

    $data = DB::table('categories as c')
        ->select(
            'c.name',
            DB::raw('count(p.id) as product_quantity'),
            DB::raw('sum(p.price) as priceAmount')
        )
        ->leftJoin('products as p', function ($join) {
            $join->on('c.id', 'p.category_id');
        })
        ->groupBy('c.id')
        ->get();

    DB::table('categories')
        ->orderBy('id')
        ->chunk(4, function ($categories) {
            dump($categories->count());
        });
});

/*
Artisan::command('exportCategories', function () {
    $categories = Category::get()->toArray();
    $file = fopen('exportCategories.csv', 'w');
    $columns = [
        'id',
        'name',
        'description',
        'picture',
        'created_at',
        'updated_at'
    ];
    fputcsv($file, $columns, ';');
    foreach($categories as $category) {
        $category['name'] = iconv('utf-8', 'windows-1251//IGNORE', $category['name']);
        $category['description'] = iconv('utf-8', 'windows-1251//IGNORE', $category['description']);
        $category['picture'] = iconv('utf-8', 'windows-1251//IGNORE', $category['picture']);
        fputcsv($file, $category, ';');
    }
    fclose($file);
});

Artisan::command('importCategoriesFromFile', function () {
    
    $file = fopen('categories.csv', 'r');

    $i = 0;
    $insert = [];
    while ($row = fgetcsv($file, 1000, ';')) {
        if ($i++ == 0) {
            $bom = pack('H*','EFBBBF');
            $row = preg_replace("/^$bom/", '', $row);
            $columns = $row;
            continue;
        }

        $data = array_combine($columns, $row);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert[] = $data;        
    }

    Category::insert($insert);
});

Artisan::command('exportProducts', function () {
    $products = Product::get()->toArray();
    $file = fopen('exportProducts.csv', 'w');
    $columns = [
        'id',
        'name',
        'description',
        'picture',
        'price',
        'category_id',
        'created_at',
        'updated_at'
    ];
    fputcsv($file, $columns, ';');
    foreach($products as $product) {
        $product['name'] = iconv('utf-8', 'windows-1251//IGNORE', $product['name']);
        $product['description'] = iconv('utf-8', 'windows-1251//IGNORE', $product['description']);
        $product['picture'] = iconv('utf-8', 'windows-1251//IGNORE', $product['picture']);
        fputcsv($file, $product, ';');
    }
    fclose($file);
});

Artisan::command('importProductsFromFile', function () {
    
    $file = fopen('products.csv', 'r');

    $i = 0;
    $insert = [];
    while ($row = fgetcsv($file, 1000, ';')) {
        if ($i++ == 0) {
            $bom = pack('H*','EFBBBF');
            $row = preg_replace("/^$bom/", '', $row);
            $columns = $row;
            continue;
        }

        $data = array_combine($columns, $row);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert[] = $data;        
    }

    Product::insert($insert);
});
*/

Artisan::command('parseEkatalog', function () {

    $url = 'https://www.e-katalog.ru/ek-list.php?search_=rtx3090&katalog_=189';

    $data = file_get_contents($url);

    $dom = new DomDocument();
    @$dom->loadHTML($data);

    $xpath = new DomXPath($dom);
    $totalProductsString = $xpath->query("//span[@class='t-g-q']")[0]->nodeValue ?? false;
    
    preg_match_all('/\d+/', $totalProductsString, $matches);
    $totalProducts = (int) $matches[0][0];

    $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

    $productsOnOnePage = $divs->length;

    $pages = ceil($totalProducts / $productsOnOnePage);

    $products = [];
    foreach ($divs as $div) {
        $a = $xpath->query("descendant::a[@class='model-short-title no-u']", $div);
        $name = $a[0]->nodeValue;

        $price = 'Нет в наличии';
        $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);

        if ($ranges->length == 1) {
            foreach ($ranges[0]->childNodes as $child) {
                if ($child->nodeName == 'a') {
                    $price = 'от ' . $child->nodeValue;
                }
            }
        }

        $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
        if ($ranges->length == 1) {
            $price = $ranges[0]->nodeValue;
        }
        $products[] = [
            'name' => $name,
            'price' => $price
        ];
    }

    for ($i = 1; $i < $pages; $i++) {
        $nextUrl = "$url&page_=$i";

        $data = file_get_contents($nextUrl);

        $dom = new DomDocument();
        @$dom->loadHTML($data);
    
        $xpath = new DomXPath($dom);
        $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

        foreach ($divs as $div) {
            $a = $xpath->query("descendant::a[@class='model-short-title no-u']", $div);
            $name = $a[0]->nodeValue;
    
            $price = 'Нет в наличии';
            $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);
    
            if ($ranges->length == 1) {
                foreach ($ranges[0]->childNodes as $child) {
                    if ($child->nodeName == 'a') {
                        $price = 'от ' . $child->nodeValue;
                    }
                }
            }
    
            $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
            if ($ranges->length == 1) {
                $price = $ranges[0]->nodeValue;
            }
            $products[] = [
                'name' => $name,
                'price' => $price
            ];
        }
    }

    $file = fopen('videocards.csv', 'w');
    foreach($products as $product) {
        fputcsv($file, $product, ';');
    }
    fclose($file);
});

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
    Auth::loginUsingId(1);
    $category = Category::find(15);
    $category->update([
        'name' => 'Блоки питания'
    ]);
});

Artisan::command('deleteCategory', function () {
    Auth::loginUsingId(1);
    $category = Category::find(14);
    $category->delete();
});

Artisan::command('createCategory', function () {
    Auth::loginUsingId(1);
    $dateNow = date('Y-m-d H:i:s');
    $category = new Category([
        'name' => 'usb hub',
        'description' => 'Категория добавленая через консоль, тест Обзервер',
        'picture' => 'categories/no_picture.png',
        'created_at' => $dateNow,
        'updated_at' => $dateNow 
    ]);
    $category->save();
});

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
