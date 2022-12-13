<?php

namespace Domain\Order\Exceptions;

use Exception;

final class PaymentProviderException extends Exception
{
    public static function providerNotRequired(): self
    {
        return new self('Провайдер не поддерживатся');
    }
}
