<?php

namespace App\Shared\Domain\Exception;

final class ForbiddenDomainOperationException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Opération interdite';
    private const DEFAULT_CODE_ERROR = 'FORBIDDEN_OPERATION';
    private const DEFAULT_REASON = 'DOMAIN_VIOLATION';

    public function __construct(string $message = self::DEFAULT_MESSAGE, string $codeError = self::DEFAULT_CODE_ERROR)
    {
        parent::__construct(
            $message, 
            $codeError,
            self::DEFAULT_REASON
        );
    }

    public static function forOwnershipViolation(): self
    {
        return new self('Opération interdite sur un agrégat étranger', 'OWNERSHIP_VIOLATION');
    }

    public static function forInvalidActor(): self
    {
        return new self('Vous n\'êtes pas autorisé à effectuer cette opération', 'ACTOR_VIOLATION');
    }
}