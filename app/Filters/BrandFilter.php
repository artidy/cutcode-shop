<?php

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Catalog\ViewModels\BrandViewModel;
use Illuminate\Database\Eloquent\Builder;

class BrandFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Бренды';
    }

    public function key(): string
    {
        return 'brands';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->request(), function (Builder $q) {
            $q->whereIn('brand_id', $this->request());
        });
    }

    public function values(): array
    {
        return BrandViewModel::make()
            ->catalogPage()
            ->pluck('title', 'id')
            ->toArray();
    }

    public function view(): string
    {
        return 'catalog.filters.brand';
    }
}
