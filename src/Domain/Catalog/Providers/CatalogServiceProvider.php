<?php

namespace Domain\Catalog\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }

    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
