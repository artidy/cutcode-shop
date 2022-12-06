<?php

namespace Domain\Order\Actions;

use Domain\Order\Contracts\NewOrderCustomerContract;
use Domain\Order\DTOs\NewOrderCustomerDTO;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderCustomer;

class NewOrderCustomerAction implements NewOrderCustomerContract
{
    public function __invoke(Order $order, NewOrderCustomerDTO $data): OrderCustomer
    {
        return $order->orderCustomer()->create([
            'order_id' => $data->order_id,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'phone' => $data->phone,
            'email' => $data->email,
            'city' => $data->city,
            'address' => $data->address
        ]);
    }
}
