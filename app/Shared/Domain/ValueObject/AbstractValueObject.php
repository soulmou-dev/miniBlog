<?php

namespace App\Shared\Domain\ValueObject;

abstract class AbstractValueObject
{
    protected mixed $value;

    public function __construct(mixed $value) {
        $this->value = $value;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function equals($other): bool
    {
        return get_class($this) === get_class($other) 
            && $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
