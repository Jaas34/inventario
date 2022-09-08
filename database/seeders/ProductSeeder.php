<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $categories = Category::factory()->count(5)->create();

        Product::factory()
            ->count(200)
            ->hasAttached($categories)
            ->create();
    }
}
