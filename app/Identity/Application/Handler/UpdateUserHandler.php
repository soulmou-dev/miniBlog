<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\UpdateUserCommand;
use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\FirstName;
use App\Identity\Domain\ValueObject\LastName;
use App\Shared\Domain\ValueObject\Id;

final class UpdateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
    ) {}

    public function __invoke( UpdateUserCommand $command): void
    {
        $user = $this->repository->findById(
            Id::fromString($command->id)
        );

        if(!$user){
            throw new UserNotFoundException();
        }

        $user->update(new LastName($command->lastName),
                     new FirstName($command->firstName) 
        );

        $this->repository->save($user);
    }
}