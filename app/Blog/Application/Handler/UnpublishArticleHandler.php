<?php

namespace App\Blog\Application\Handler;

use App\Blog\Application\Command\UnpublishArticleCommand;
use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Shared\Domain\ValueObject\Id;

final class UnpublishArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface$repository
    ) {}

    public function __invoke( UnpublishArticleCommand $command): void
    {

        $article = $this->repository->findById(Id::fromString($command->id));

        if(!$article){
            throw new ArticleNotFoundException();
        }

        $article->assertOwnedBy(Id::fromString($command->authorId)); 

        $article->unpublish();

        $this->repository->save($article);
    }
}