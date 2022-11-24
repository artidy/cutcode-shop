<?php

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class PriceFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Цена';
    }

    public function key(): string
    {
        return 'price';
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween('price', [
            $this->request('from', 0) * 100,
            $this->request('to', 1000000) * 100
        ]);
    }

    public function values(): array
    {
        return [
            'from' => 0,
            'to' => 100000,
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }
}
