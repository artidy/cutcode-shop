<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\NewOrderCustomerContract;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\NewOrderCustomerDTO;
use Domain\Order\Models\Order;

final class AssignCustomer implements OrderProcessContract
{
    public function __construct(
        private readonly array $customer
    ) {}

    public function handle(Order $order, $next)
    {
        $action = app(NewOrderCustomerContract::class);

        $action($order, NewOrderCustomerDTO::make(
            $order->id,
            $this->customer['first_name'],
            $this->customer['last_name'],
            $this->customer['email'],
            $this->customer['phone'],
            $this->customer['city'],
            $this->customer['address'],
        ));

        return $next($order);
    }
}
