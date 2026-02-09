<?php

namespace App\Identity\Domain\ValueObject;

enum UserRole: string
{
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';    

    public function value():string
    {
        return $this->value;
    }
}
