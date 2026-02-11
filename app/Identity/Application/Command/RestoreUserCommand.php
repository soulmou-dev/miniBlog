<?php

namespace App\Identity\Application\Command;

final class RestoreUserCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $role
    ) {}

    public static function fromData(array $data): self
    {
        return new self(
            $data['id'],
            $data['role'],
        );
    }
}