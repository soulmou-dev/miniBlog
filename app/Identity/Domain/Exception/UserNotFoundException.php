<?php

namespace App\Identity\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class UserNotFoundException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Utilisateur introuvable';
    private const DEFAULT_CODE_ERROR = 'USER_NOT_FOUND';
    private const DEFAULT_REASON = 'NOT_FOUND';

    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct(
            $message, 
            self::DEFAULT_CODE_ERROR,
            self::DEFAULT_REASON
        );
    }
}