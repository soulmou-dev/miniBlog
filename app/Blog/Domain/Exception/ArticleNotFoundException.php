<?php

namespace App\Blog\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class ArticleNotFoundException extends AbstractDomainException
{
    private const DEFAULT_MESSAGE = 'Article introuvable';
    private const DEFAULT_CODE_ERROR = 'ARTICLE_NOT_FOUND';
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