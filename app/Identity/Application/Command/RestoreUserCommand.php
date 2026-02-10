<?php

namespace App\Identity\Application\Command;

final class RestoreUserCommand
{
    public function __construct(
        public readonly string $id
    ) {}
}