<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidEmailException;

final class Email extends AbstractValueObject
{
    public function __construct(string $email)
    {
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            throw new InvalidEmailException();
        }
        
        parent::__construct($email);
    }
}