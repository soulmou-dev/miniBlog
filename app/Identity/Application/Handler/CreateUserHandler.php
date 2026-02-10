<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\CreateUserCommand;
use App\Identity\Application\Security\PasswordHasherInterface;
use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Exception\UserAlreadyExistsException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\FirstName;
use App\Identity\Domain\ValueObject\LastName;
use App\Identity\Domain\ValueObject\UserRole;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

final class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordHasherInterface $hasher
    ) {}

    public function __invoke( CreateUserCommand $command): void
    {
        if($this->repository->existsByEmail($command->email)){
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            Id::generate(),
            new Email($command->email),
            new LastName($command->lastName),
            new FirstName($command->firstName),
            UserRole::USER
        );

        $hashedPassword = $this->hasher->hash($command->password);

        $this->repository->save($user, $hashedPassword);
    }

}