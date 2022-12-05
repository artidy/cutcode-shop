<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class CancelledOrderState extends OrderState
{
    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): OrderStatuses
    {
        return OrderStatuses::Cancelled;
    }

    public function title(): string
    {
        return 'Отменен';
    }
}
