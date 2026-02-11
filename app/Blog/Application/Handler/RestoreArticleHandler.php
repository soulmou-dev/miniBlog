<?php

namespace App\Blog\Application\Handler;

use App\Blog\Application\Command\RestoreArticleCommand;
use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;
use App\Shared\Domain\ValueObject\Id;

final class RestoreArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface$repository
    ) {}

    public function __invoke( RestoreArticleCommand $command): void
    {

        $article = $this->repository->findById(Id::fromString($command->id), true);

        if(!$article){
            throw new ArticleNotFoundException();
        }

        if($command->role  !== 'ROLE_ADMIN'){ 
            throw ForbiddenDomainOperationException::forInvalidActor();      
        }

        $article->restore();
        // on sauvegarde le statut avant d'executer restore
        $this->repository->save($article);

        $this->repository->restore($article->id());
    }
}