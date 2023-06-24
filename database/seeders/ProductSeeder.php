<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => Str::uuid(),
                'title_en' => "Shoe 1",
                'title_bn' => "Shoe 1",
                'slug' => Str::slug('Shoe 1'),
                'sku' => "eco-80564",
                'content_en' => "The Test Content One",
                'content_bn' => "The Test Content One",
                'cost_price' => "29.99",
                'sales_price' => "35.99",
                'compare_price' => "30",
                'profit_margin' => "30",
                'order' => "1",
                'tax_id' => "1",
                'is_featured' => 1,
                'is_variation' => 1,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid(),
                'title_en' => "Shoe 2",
                'title_bn' => "Shoe 2",
                'slug' => Str::slug('Shoe 2'),
                'sku' => "eco-80565",
                'content_en' => "The Test Content Two",
                'content_bn' => "The Test Content Two",
                'cost_price' => "19.99",
                'sales_price' => "32.99",
                'compare_price' => "20",
                'profit_margin' => "20",
                'order' => "1",
                'tax_id' => "1",
                'is_featured' => 1,
                'is_variation' => 1,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $product = Product::insert($data);

//        $product->categories()->attach([1, 3]);
    }
}
