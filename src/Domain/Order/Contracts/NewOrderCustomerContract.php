<?php

namespace Domain\Order\Contracts;

use Domain\Order\DTOs\NewOrderCustomerDTO;
use Domain\Order\Models\Order;

interface NewOrderCustomerContract
{
    public function __invoke(Order $order, NewOrderCustomerDTO $data);
}
