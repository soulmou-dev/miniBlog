<?php

namespace App\Identity\Application\Command;

final class CreateUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirmation,
        public readonly string $lastName,
        public readonly string $firstName
    ) {}

    public static function fromData(array $data): self
    {
        return new self(
            $data['email'],
            $data['password'],
            $data['password_confirmation'],
            $data['last_name'],
            $data['first_name']
        );
    }
}