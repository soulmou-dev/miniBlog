<?php

namespace App\Identity\Application\Command;

final class DeleteUserCommand
{
    public function __construct(
        public readonly string $id
    ) {}
}