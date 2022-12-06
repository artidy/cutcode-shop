<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\NewOrderItemsContract;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\NewOrderItemsDTO;
use Domain\Order\Models\Order;

final class AssignProducts implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $action = app(NewOrderItemsContract::class);

        $action($order, NewOrderItemsDTO::fromCart($order->id));

        return $next($order);
    }
}
