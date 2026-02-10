<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\UpdateUserCommand;
use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\ValueObject\Id;

final class DeleteUserHandler
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

        $user->delete();

        $this->repository->delete(Id::fromString($command->id));
    }

}