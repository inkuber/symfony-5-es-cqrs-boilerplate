<?php

namespace App\Shared\Domain\ValueObject;

class Name
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name)
    {
        return new Name($name);
    }

    public function __toString()
    {
        return $this->name;
    }
}
