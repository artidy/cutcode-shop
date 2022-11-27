<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $brands = BrandViewModel::make()->catalogPage();

        $categories = CategoryViewModel::make()->catalogPage();

        $products = Product::query()
            ->catalogPage($category)
            ->paginate(6);

        return view('catalog.index', compact(
            'categories',
            'brands',
            'products',
            'category'
        ));
    }
}
