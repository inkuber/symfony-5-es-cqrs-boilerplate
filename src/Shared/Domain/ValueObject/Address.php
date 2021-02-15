<?php

namespace App\Shared\Domain\ValueObject;

final class Address
{
    private string $address;

    private function __construct(string $address)
    {
        $this->address = $address;
    }

    public static function fromString(string $address) : Address
    {
        return new Address($address);
    }

    public function __toString() : string
    {
        return $this->address;
    }
}
