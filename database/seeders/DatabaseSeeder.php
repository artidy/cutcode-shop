<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
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
        BrandFactory::new()->count(20)->create();
        CategoryFactory::new()->count(20)
            ->has(Product::factory(rand(5, 20)))
            ->create();
    }
}
