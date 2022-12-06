<?php

namespace Domain\Order\Processes;

use App\Http\Requests\OrderFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;

final class CreateUser implements OrderProcessContract
{
    public function __construct(
        private readonly OrderFormRequest $request
    ) {}

    public function handle(Order $order, $next)
    {
        if (!auth()->check() && $this->request->boolean('create_account')) {
            $registrationAction = app(RegisterNewUserContract::class);
            $registrationAction(NewUserDTO::fromRequest($this->request));
        }

        return $next($order);
    }
}
