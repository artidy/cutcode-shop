<?php

namespace Domain\Order\Processes;

use App\Http\Requests\OrderFormRequest;
use Domain\Order\Contracts\NewOrderContract;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

final class CreateOrder implements OrderProcessContract
{

    public function __construct(
        private readonly OrderFormRequest $request
    ) {}

    public function handle(Order $order, $next)
    {
        $action = app(NewOrderContract::class);

        $order = $action(NewOrderDTO::make(
            auth()->id(),
            $this->request->get('delivery_type_id'),
            $this->request->get('payment_method_id'),
            cart()->amount()->raw()
        ));

        return $next($order);
    }
}
