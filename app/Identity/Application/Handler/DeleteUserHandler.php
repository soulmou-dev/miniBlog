<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\DeleteUserCommand;
use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;
use App\Shared\Domain\ValueObject\Id;

final class DeleteUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function __invoke( DeleteUserCommand $command): void
    {

        $user = $this->repository->findById(Id::fromString($command->id));

        if(!$user){
            throw new UserNotFoundException();
        }

        if($command->role  !== 'ROLE_ADMIN'){ 
            throw ForbiddenDomainOperationException::forInvalidActor();      
        }

        $user->delete();

        $this->repository->delete($user->id());
    }
}