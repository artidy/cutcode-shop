<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = CategoryViewModel::make()->homePage();

        $brands = BrandViewModel::make()->homePage();

        $products = Product::query()
            ->homePage()
            ->get();

        return view('index', compact(
            'categories',
            'brands',
            'products'
        ));
    }
}
