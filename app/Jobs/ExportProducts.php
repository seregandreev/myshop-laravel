<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::get()->toArray();
        $file = fopen('public/storage/export/exportProducts.csv', 'w');
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
    }
}
