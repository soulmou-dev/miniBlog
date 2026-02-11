<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\UpdateUserCommand;
use App\Identity\Application\Security\PasswordHasherInterface;
use App\Identity\Domain\Exception\UserAlreadyExistsException;
use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Domain\Exception\ValidationPasswordException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\FirstName;
use App\Identity\Domain\ValueObject\LastName;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

final class UpdateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordHasherInterface $hasher
    ) {}

    public function __invoke( UpdateUserCommand $command): void
    {
        if($command->password && $command->password !== $command->passwordConfirmation){
            throw new ValidationPasswordException();
        }

        $user = $this->repository->findById(
            Id::fromString($command->id)
        );

        if(!$user){
            throw new UserNotFoundException();
        }

        if($user->email()->equals(new Email($command->email)) ===false){
            if($this->repository->existsByEmail($command->email)){
                throw new UserAlreadyExistsException('Email déjà utilisé');
            }
        }  

        $user->update( new Email($command->email),
                    new LastName($command->lastName),
                    new FirstName($command->firstName) 
        );

        $hashedPassword = null;
        if($command->password) {
            $hashedPassword = $this->hasher->hash($command->password);
        }
       
        $this->repository->save($user, $hashedPassword);
    }
}