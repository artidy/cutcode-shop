<?php

namespace Domain\Catalog\QueryBuilders;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

class BrandQueryBuilder extends Builder
{
    public function homePage(): BrandQueryBuilder
    {
        return $this->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function catalogPage(): BrandQueryBuilder
    {
        return $this->select(['id', 'title'])
            ->has('products');
    }
}
