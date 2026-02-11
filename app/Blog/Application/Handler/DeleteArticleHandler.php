<?php

namespace App\Blog\Application\Handler;

use App\Blog\Application\Command\DeleteArticleCommand;
use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Shared\Domain\ValueObject\Id;

final class DeleteArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface$repository
    ) {}

    public function __invoke( DeleteArticleCommand $command): void
    {

        $article = $this->repository->findById(Id::fromString($command->id));

        if(!$article){
            throw new ArticleNotFoundException();
        }

        if($command->role  !== 'ROLE_ADMIN'){ 
            $article->assertOwnedBy(Id::fromString($command->authorId));         
        }

        $article->delete();
        // on sauvegarde le statut avant d'executer un sof delete
        $this->repository->save($article);

        $this->repository->delete($article->id());
    }
}