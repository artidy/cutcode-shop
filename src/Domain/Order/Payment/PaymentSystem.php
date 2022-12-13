<?php

namespace Domain\Order\Payment;

use Closure;
use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Exceptions\PaymentProcessException;
use Domain\Order\Exceptions\PaymentProviderException;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\States\Payment\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;

final class PaymentSystem
{
    use PaymentEvents;

    protected static PaymentGatewayContract $provider;

    /**
     * @throws PaymentProviderException
     */
    public static function provider(PaymentGatewayContract|Closure $data): void
    {
        if (is_callable($data)) {
            $data = call_user_func($data);
        }

        if (!$data instanceof PaymentGatewayContract) {
            throw PaymentProviderException::providerNotRequired();
        }

        self::$provider = $data;
    }

    /**
     * @throws PaymentProviderException
     */
    public static function create(PaymentData $paymentData): PaymentGatewayContract
    {
        if (!self::$provider instanceof PaymentGatewayContract) {
            throw PaymentProviderException::providerNotRequired();
        }

        Payment::query()->create([
            'payment_id' => $paymentData->id,
            'payment_gateway' => get_class(self::$provider),
            'meta' => $paymentData->meta
        ]);

        if (is_callable(self::$onCreating)) {
            $paymentData = call_user_func(self::$onCreating, $paymentData);
        }

        return self::$provider->data($paymentData);
    }

    /**
     * @throws PaymentProviderException
     */
    public static function validate(): PaymentGatewayContract
    {
        if (!self::$provider instanceof PaymentGatewayContract) {
            throw PaymentProviderException::providerNotRequired();
        }

        PaymentHistory::query()->create([
            'method' => request()->method(),
            'payload' => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider)
        ]);

        if (is_callable(self::$onValidating)) {
            call_user_func(self::$onValidating);
        }

        if (self::$provider->validate() && self::$provider->paid()) {
            try {
                $payment = Payment::query()
                    ->where('payment_id', self::$provider->paymentId())
                    ->firstOr(function () {
                        throw PaymentProcessException::paymentQueryNotCorrect();
                    });

                if (is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionTo(PaidPaymentState::class);
            } catch (PaymentProcessException $e)
            {
                if (is_callable(self::$onError)) {
                    call_user_func(
                        self::$onError,
                        self::$provider->errorMessage() ?? $e->getMessage()
                    );
                }
            }
        }

        return self::$provider;
    }
}
