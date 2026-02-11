<?php

namespace App\Blog\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class InvalidArticleTitleException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Titre de l\'article invalide';
    private const DEFAULT_CODE_ERROR = 'INVALID_ARTICLE_TITLE';
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