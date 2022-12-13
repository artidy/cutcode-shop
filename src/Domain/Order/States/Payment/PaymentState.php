<?php

namespace Domain\Order\States\Payment;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PaymentState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PendingPaymentState::class)
            ->allowTransition(PendingPaymentState::class, PaidPaymentState::class)
            ->allowTransition(PendingPaymentState::class, CancelledPaymentState::class);
    }
}
