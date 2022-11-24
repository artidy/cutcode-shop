<?php

namespace Domain\Catalog\Providers;

use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManager;
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
            new PriceFilter()
        ]);
    }
}
