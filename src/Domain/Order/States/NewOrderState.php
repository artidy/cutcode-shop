<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendingOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): OrderStatuses
    {
        return OrderStatuses::New;
    }

    public function title(): string
    {
        return 'Новый заказ';
    }
}
