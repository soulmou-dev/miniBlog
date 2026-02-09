<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidIdException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

final class Id
{
    private UuidInterface $value;

    private function __construct(UuidInterface $uuid)
    {
        $this->value = $uuid;
    }

    public function value(): UuidInterface
    {
        return $this->value;
    }

    public static function fromString(string $id): self
    {
        if (!self::isValidUuidV7($id)) {
            throw new InvalidIdException();
        }

        return new self(Uuid::fromString($id));
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid7());
    }

    public static function isValidUuidV7(string $uuid): bool
    {
        try {
            $u = Uuid::fromString($uuid);
            return $u->getVersion() === 7;
        } catch (InvalidUuidStringException) {
            return false;
        }
    }

    public function equals(self $other): bool
    {
        return $this->value->equals($other->value());
    }

    public function __toString(): string
    {
        return $this->value->toString();
    }
}
