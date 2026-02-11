<?php

namespace App\Blog\Domain\ValueObject;

use App\Blog\Domain\Exception\InvalidArticleTitleException;
use App\Shared\Domain\ValueObject\AbstractValueObject;


final class ArticleTitle extends AbstractValueObject
{
    public function __construct(string $title)
    {
        $title = trim($title);
        
        if($title==='') {
            throw new InvalidArticleTitleException('le titre de l\'article ne doit pas être null');
        }

        if (mb_strlen($title) < 2) {
            throw new InvalidArticleTitleException('le titre de l\'article est trop court');
        }

        if (mb_strlen($title) > 255) {
            throw new InvalidArticleTitleException('le titre de l\'article est trop long');
        }

        parent::__construct($title);
    }
}
