<?php

namespace App\Blog\Application\Handler;

use App\Blog\Application\Command\RejectArticleCommand;
use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;
use App\Shared\Domain\ValueObject\Id;

final class RejectArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface$repository
    ) {}

    public function __invoke( RejectArticleCommand $command): void
    {

        $article = $this->repository->findById(Id::fromString($command->id), true);

        if(!$article){
            throw new ArticleNotFoundException();
        }

        if($command->role  !== 'ROLE_ADMIN'){ 
            throw ForbiddenDomainOperationException::forInvalidActor();      
        }

        $article->reject();

        $this->repository->save($article);
    }
}