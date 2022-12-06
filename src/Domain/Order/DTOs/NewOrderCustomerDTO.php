<?php

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

final class NewOrderCustomerDTO
{
    use Makeable;

    public function __construct(
        public readonly string $order_id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $city,
        public readonly string $address,
    ) {}
}
