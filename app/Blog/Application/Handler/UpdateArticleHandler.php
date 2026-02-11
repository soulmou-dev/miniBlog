<?php

namespace App\Blog\Application\Handler;

use App\Blog\Application\Command\UpdateArticleCommand;
use App\Blog\Domain\Entity\Article;
use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Blog\Domain\ValueObject\ArticleContent;
use App\Blog\Domain\ValueObject\ArticleStatus;
use App\Blog\Domain\ValueObject\ArticleTitle;
use App\Shared\Domain\ValueObject\Id;

final class UpdateArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface$repository
    ) {}

    public function __invoke( UpdateArticleCommand $command): void
    {

        $article = $this->repository->findById(Id::fromString($command->id));

        if(!$article){
            throw new ArticleNotFoundException();
        }

        if($command->role  !== 'ROLE_ADMIN'){ 
            $article->assertOwnedBy(Id::fromString($command->authorId));         
        }

        $article->update(
            new ArticleTitle($command->title),
            new ArticleContent($command->content)
        );

        $this->repository->save($article);
    }
}