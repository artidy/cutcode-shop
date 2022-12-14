<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever('category home page', function() {
            return $categories = Category::query()
                ->homePage()
                ->get();
        });
    }

    public function catalogPage(): Collection|array
    {
        return Cache::rememberForever('category catalog page', function() {
            return $categories = Category::query()
                ->catalogPage()
                ->get();
        });
    }
}
