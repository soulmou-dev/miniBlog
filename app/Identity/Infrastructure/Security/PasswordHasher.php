<?php

namespace App\Identity\Infrastructure\Security;

use App\Identity\Application\Security\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $plainPassword): string
    {
        return Hash::make($plainPassword);
    }
}