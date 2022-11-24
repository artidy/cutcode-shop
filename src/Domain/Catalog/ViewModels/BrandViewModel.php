<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class BrandViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever('brand home page', function() {
            return $brands = Brand::query()
                ->homePage()
                ->get();
        });
    }

    public function catalogPage(): Collection|array
    {
        return Cache::rememberForever('brand catalog page', function() {
            return $brands = Brand::query()
                ->catalogPage()
                ->get();
        });
    }
}
