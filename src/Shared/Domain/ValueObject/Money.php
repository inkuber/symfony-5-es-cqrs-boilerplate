<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Currency;

class Money
{
    private int $value;
    private Currency $currency;
    private int $precision;

    public function __construct(int $value, Currency $currency, int $precision = 2)
    {
        $this->value = $value * pow(10, $precision);
        $this->currency = $currency;
        $this->precision = $precision;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function __toString() : string
    {
        return sprintf("%.2f %s", $this->value/pow(10, $this->precision), $this->currency->code());
    }
}
