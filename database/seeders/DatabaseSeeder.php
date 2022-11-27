<?php

namespace Database\Seeders;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Domain\Product\Models\Property;
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
        PropertyFactory::new()->count(10)->create();
        OptionFactory::new()->count(2)->create();
        OptionValueFactory::new()->count(10)->create();

        CategoryFactory::new()->count(20)
            ->has(PropertyFactory::new()->count(rand(5, 20))
                ->hasAttached(OptionValue::all()->random(10))
                ->hasAttached(Property::all()->random(10), function () {
                    return ['value' => ucfirst(fake()->word())];
                }))
            ->create();
    }
}
