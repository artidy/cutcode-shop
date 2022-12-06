<?php

namespace Domain\Order\Providers;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Order\Actions\NewOrderAction;
use Domain\Order\Actions\NewOrderCustomerAction;
use Domain\Order\Actions\NewOrderItemsAction;
use Domain\Order\Contracts\NewOrderContract;
use Domain\Order\Contracts\NewOrderCustomerContract;
use Domain\Order\Contracts\NewOrderItemsContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class,
        NewOrderContract::class => NewOrderAction::class,
        NewOrderCustomerContract::class => NewOrderCustomerAction::class,
        NewOrderItemsContract::class => NewOrderItemsAction::class
    ];
}
