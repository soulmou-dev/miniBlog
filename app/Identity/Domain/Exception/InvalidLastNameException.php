<?php

namespace App\Identity\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class InvalidLastNameException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Nom invalide';
    private const DEFAULT_CODE_ERROR = 'INVALID_LAST_NAME';
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