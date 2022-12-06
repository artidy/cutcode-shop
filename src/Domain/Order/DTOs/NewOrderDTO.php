<?php

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

final class NewOrderDTO
{
    use Makeable;

    public function __construct(
        public readonly string|null $user_id,
        public readonly string $delivery_type_id,
        public readonly string $payment_method_id,
        public readonly string $amount
    ) {}
}
