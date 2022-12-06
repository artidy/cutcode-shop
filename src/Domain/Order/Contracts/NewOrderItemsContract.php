<?php

namespace Domain\Order\Contracts;

use Domain\Order\DTOs\NewOrderItemsDTO;
use Domain\Order\Models\Order;

interface NewOrderItemsContract
{
    public function __invoke(Order $order, NewOrderItemsDTO $data);
}
