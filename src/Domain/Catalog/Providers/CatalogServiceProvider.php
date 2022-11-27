<?php

namespace Domain\Catalog\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ActionsServiceProvider::class);
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        $this->registerPolicies();

        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter()
        ]);

        $this->app->bind(Sorter::class, function () {
            return new Sorter([
                'title',
                'price'
            ]);
        });
    }
}
