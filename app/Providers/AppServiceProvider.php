<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(!app()->isProduction());

        if (!app()->isProduction()) {
            return;
        }

        DB::listen(function ($query) {
            if ($query->time > 500) {
                logger()
                    ->channel('telegram')
                    ->debug('Долгое выполнение запроса: ' . $query->sql, $query->bindings);
            }
        });

        $kernel = app(Kernel::class);

        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function () {
                logger()
                    ->channel('telegram')
                    ->debug('Долгая загрузка страницы: ' . request()->url());
            }
        );
    }
}
