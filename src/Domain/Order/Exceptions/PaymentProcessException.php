<?php

namespace Domain\Order\Exceptions;

use Exception;

final class PaymentProcessException extends Exception
{
    public static function paymentQueryNotCorrect(): self
    {
        return new self('Некорректные данные запроса');
    }
}
