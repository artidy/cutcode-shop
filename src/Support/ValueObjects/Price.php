<?php

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

final class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'KZT' => 'тңг',
        'RUB' => '₽',
        'USD' => '$',
        'EUR' => '€'
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100
    )
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Значение не может быть меньше 0');
        }

        if (!isset($this->currencies[$currency])) {
            throw new InvalidArgumentException("$currency - валюта не поддерживается");
        }
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function currencySymbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString()
    {
        return number_format($this->value(), 2, ',', ' ')
            . ' ' . $this->currencySymbol();
    }
}
