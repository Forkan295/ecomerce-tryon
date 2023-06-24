<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $query = CategoryType::query();

        if ($query->count() == 0) {
            $query->insert(
                [
                    ['title' => 'Ornaments', 'slug' => 'ornaments'],
                    ['title' => 'Shoes', 'slug' => 'shoes'],
                    ['title' => 'Cloth', 'slug' => 'cloth']
                ]
            );
        }

    }
}
