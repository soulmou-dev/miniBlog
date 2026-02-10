<?php

namespace App\Identity\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class ValidationPasswordException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Les mots de passe ne correspondanet pas';
    private const DEFAULT_CODE_ERROR = 'PASSWORD_MISMATCH';
    private const DEFAULT_REASON = 'VALIDATION_ERROR';

    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct(
            $message, 
            self::DEFAULT_CODE_ERROR,
            self::DEFAULT_REASON
        );
    }
}