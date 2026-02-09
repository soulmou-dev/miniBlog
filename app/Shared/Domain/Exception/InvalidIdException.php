<?php

namespace App\Shared\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class InvalidIdException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Id de client invalide';
    private const DEFAULT_CODE_ERROR = 'INVALID_CUSTOMER_ID';
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