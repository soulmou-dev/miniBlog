<?php

namespace App\Identity\Application\Security;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;
}