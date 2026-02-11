<?php

namespace App\Identity\Application\Command;

final class UpdateUserCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?string $passwordConfirmation,
        public readonly string $lastName,
        public readonly string $firstName
    ) {}

    public static function fromData(array $data, string $id): self
    {
        return new self(
            $id,
            $data['email'],
            $data['password'],
            $data['password_confirmation'],
            $data['last_name'],
            $data['first_name']
        );
    }
}