<?php

namespace App\Shared\Domain\ValueObject;

class Currency
{
    private string $code;

    protected function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function fromCode(string $code)
    {
        static $currencies = [];

        if (!isset($currencies[$code])) {
            $currencies[$code] = new Currency($code);
        }

        return $currencies[$code];
    }

    public function code(): string
    {
        return $this->code;
    }
}
