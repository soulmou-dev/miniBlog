<?php

namespace App\Identity\Application\Command;

final class UpdateUserCommand
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $lastName = null,
        public readonly ?string $firstName = null
    ) {}

    public static function fromData(array $data, string $id): self
    {
        return new self(
            $id,
            $data['lastName'],
            $data['emafirstNameil']
        );
    }
}