<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): OrderStatuses
    {
        return OrderStatuses::Pending;
    }

    public function title(): string
    {
        return 'В обработке...';
    }
}
