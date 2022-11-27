<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->load(['optionValues.option']);

        $sessionAlso = session('also');
        $also = [];

        if ($sessionAlso) {
            $also = Product::query()
                ->where(function ($query) use ($product, $sessionAlso) {
                    $query->whereIn('id', $sessionAlso)
                        ->where('id', '!=', $product->id);
                })
                ->get();
        }

        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'also' => $also,
        ]);
    }
}
