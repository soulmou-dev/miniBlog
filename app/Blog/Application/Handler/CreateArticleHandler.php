<?php

namespace App\Blog\Application\Handler;

use App\Blog\Application\Command\CreateArticleCommand;
use App\Blog\Domain\Entity\Article;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Blog\Domain\ValueObject\ArticleContent;
use App\Blog\Domain\ValueObject\ArticleStatus;
use App\Blog\Domain\ValueObject\ArticleTitle;
use App\Shared\Domain\ValueObject\Id;

final class CreateArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface$repository
    ) {}

    public function __invoke( CreateArticleCommand $command): void
    {
        $article = new Article(
            Id::generate(),
            Id::fromString($command->authorId),
            new ArticleTitle($command->title),
            new ArticleContent($command->content),
            ArticleStatus::PENDING_VALIDATION
        );

        $this->repository->save($article);
    }

}