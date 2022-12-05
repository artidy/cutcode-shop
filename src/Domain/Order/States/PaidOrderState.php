<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): OrderStatuses
    {
        return OrderStatuses::Paid;
    }

    public function title(): string
    {
        return 'Оплачен';
    }
}
