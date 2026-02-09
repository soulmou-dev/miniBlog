<?php

namespace App\Identity\Domain\ValueObject;

use App\Identity\Domain\Exception\InvalidLastNameException;
use App\Shared\Domain\ValueObject\AbstractValueObject;

final class FirstName extends AbstractValueObject
{
    public function __construct(string $name)
    {
        $name = trim($name);
        
        if($name==='') {
            throw new InvalidLastNameException('le prénom ne doit pas être null');
        }

        if (mb_strlen($name) < 2) {
            throw new InvalidLastNameException('le prénom est trop court (min: 3)');
        }

        if (mb_strlen($name) > 255) {
            throw new InvalidLastNameException('le prénom est trop long (max: 255)');
        }

        parent::__construct($name);
    }
}