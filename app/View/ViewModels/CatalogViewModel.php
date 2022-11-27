<?php

namespace App\View\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public Category $category
    ) {}

    public function brands(): Collection|array
    {
        return BrandViewModel::make()->catalogPage();
    }

    public function categories(): Collection|array
    {
        return CategoryViewModel::make()->catalogPage();
    }

    public function products(): LengthAwarePaginator
    {
        return Product::query()
            ->catalogPage($this->category)
            ->paginate(6);
    }
}
