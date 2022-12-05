<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;
use Domain\Order\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [];

    public function __construct(
        protected Order $order
    ) {}

    abstract public function canBeChanged(): bool;

    abstract public function value(): OrderStatuses;

    abstract public function title(): string;

    public function transitionTo(OrderState $state): void
    {
        if (!$this->canBeChanged()) {
            throw new InvalidArgumentException('Статус нельзя изменить');
        }

        if (!in_array(get_class($state), $this->allowedTransitions)) {
            throw new InvalidArgumentException(
                "Нельзя сменить статус с {$this->order->status->value()} на {$state->value()}"
            );
        }

        $this->order->updateQuietly([
            'status' => $state->value()
        ]);

        event(new OrderStatusChanged($this->order, $this->order->status, $state));
    }
}
