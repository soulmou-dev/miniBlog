<?php

namespace App\Blog\Domain\ValueObject;

use App\Blog\Domain\Exception\InvalidArticleContentException;
use App\Shared\Domain\ValueObject\AbstractValueObject;

final class ArticleContent extends AbstractValueObject
{
    private const MAX_LENGTH = 10000;

    public function __construct(?string $content)
    {
        $description = trim($content);
        
        if ($content !==null && mb_strlen($content) > self::MAX_LENGTH) {
            throw new InvalidArticleContentException('Le contenu de l\'article est trop long');
        }

        parent::__construct($content);
    }
}