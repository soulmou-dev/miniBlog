<?php

namespace App\Identity\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class UserAlreadyExistsException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Utilisateur existe déjà';
    private const DEFAULT_CODE_ERROR = 'USER_ALREADY_EXIST';
    private const DEFAULT_REASON = 'CONFLIT';

    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct(
            $message, 
            self::DEFAULT_CODE_ERROR,
            self::DEFAULT_REASON
        );
    }
}