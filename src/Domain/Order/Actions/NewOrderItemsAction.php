<?php

namespace Domain\Order\Actions;

use Domain\Order\Contracts\NewOrderItemsContract;
use Domain\Order\DTOs\NewOrderItemsDTO;
use Domain\Order\Models\Order;

final class NewOrderItemsAction implements NewOrderItemsContract
{
    public function __invoke(Order $order, NewOrderItemsDTO $data)
    {
        $order->orderItems()->createMany($data->items());
    }
}
