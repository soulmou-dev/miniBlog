<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\RestoreUserCommand;
use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;
use App\Shared\Domain\ValueObject\Id;

final class RestoreUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function __invoke( RestoreUserCommand $command): void
    {

        $user = $this->repository->findById(Id::fromString($command->id), true);

        if(!$user){
            throw new UserNotFoundException();
        }

        if($command->role  !== 'ROLE_ADMIN'){ 
            throw ForbiddenDomainOperationException::forInvalidActor();      
        }

        $user->restore();

        $this->repository->restore($user->id());
    }
}