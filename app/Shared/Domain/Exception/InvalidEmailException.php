<?php

namespace App\Shared\Domain\Exception;

final class InvalidEmailException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Email invalide';
    private const DEFAULT_CODE_ERROR = 'INVALID_EMAIL';
    private const DEFAULT_REASON = 'INVALID_TYPE';

    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct(
            $message, 
            self::DEFAULT_CODE_ERROR,
            self::DEFAULT_REASON
        );
    }
}