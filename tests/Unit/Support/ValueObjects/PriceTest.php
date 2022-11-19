<?php

namespace Tests\Unit\Support\ValueObjects;

use InvalidArgumentException;
use Support\ValueObjects\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    protected Price $price;
    private string $currency = 'RUB';
    private string $currencySymbol = '₽';
    private int $value = 10000;
    private int $precision = 100;

    protected function setUp(): void
    {
        parent::setUp();

        $this->price = Price::make(
            $this->value,
            $this->currency,
            $this->precision
        );
    }

    public function test_it_created_instance_price_success(): void
    {
        $this->assertInstanceOf(Price::class, $this->price);
    }

    public function test_it_value_success(): void
    {
        $this->assertEquals($this->value / $this->precision, $this->price->value());
    }

    public function test_it_raw_success(): void
    {
        $this->assertEquals($this->value, $this->price->raw());
    }

    public function test_it_currency_success(): void
    {
        $this->assertEquals($this->currency, $this->price->currency());
    }

    public function test_it_currency_symbol_success(): void
    {
        $this->assertEquals($this->currencySymbol, $this->price->currencySymbol());
    }

    public function test_it_result_success(): void
    {
        $result = $this->value / $this->precision;

        $this->assertEquals("$result,00 $this->currencySymbol", $this->price);
    }

    public function test_it_negative_value_fail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Price::make(-10000);
    }

    public function test_it_not_support_currency_fail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Price::make(10000, 'TRY');
    }
}
