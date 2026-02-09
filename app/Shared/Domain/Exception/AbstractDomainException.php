<?php

namespace App\Shared\Domain\Exception;

use DomainException;

abstract class AbstractDomainException extends DomainException implements DomainExceptionInterface
{
    protected string $codeError;
    protected string $reason;

    public function __construct(string $message, string $codeError, string $reason)
    {
        parent::__construct($message);
        $this->codeError = $codeError;
        $this->reason = $reason;
    }

    public function reason():string
    {
        return $this->reason;
    }

    public function getErrorCode(): string
    {
        return $this->codeError;
    }
}