<?php

namespace Domain\Order\DTOs;

use Support\Traits\Makeable;

final class NewOrderItemsDTO
{
    use Makeable;

    public function __construct(
        private readonly array $items
    ) {}

    public static function fromCart(int $orderId): NewOrderItemsDTO
    {
        return self::make(cart()->items()->map(function ($item) use($orderId) {
            return [
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'price' => $item->price,
                'quantity' => $item->quantity
            ];
        })->toArray());
    }

    public function items(): array
    {
        return $this->items;
    }
}
