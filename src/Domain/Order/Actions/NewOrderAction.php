<?php

namespace Domain\Order\Actions;

use Domain\Order\Contracts\NewOrderContract;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

class NewOrderAction implements NewOrderContract
{
    public function __invoke(NewOrderDTO $data): Order
    {
        return Order::query()->create([
            'user_id' => $data->user_id,
            'delivery_type_id' => $data->delivery_type_id,
            'payment_method_id' => $data->payment_method_id,
            'amount' => $data->amount,
        ]);
    }
}
