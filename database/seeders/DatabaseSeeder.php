<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Brand::factory(20)->create();
        Category::factory(20)->create();
        Product::factory(20)
            ->create()
            ->each(function (Product $product) {
                $product
                    ->categories()
                    ->attach(Category::query()->inRandomOrder()->offset(rand(1, 3))->value('id'));
            });
    }
}
