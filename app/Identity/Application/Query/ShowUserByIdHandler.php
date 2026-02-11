<?php

namespace App\Identity\Application\Query;

use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Infrastructure\Persistence\Eloquent\UserModel;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;

final class ShowUserByIdHandler
{
    public function __invoke(string $id, ?array $connectedUser = null): UserModel
    {
        $user = UserModel::withCount('articles')
                        ->where('id', '=', $id)
                        ->withTrashed()->first();

        if(!$user){
            throw new UserNotFoundException();
        }

        if($user->role === 'ROLE_ADMIN' && 
            ($connectedUser === null || $connectedUser['role'] !== 'ROLE_ADMIN'))
        {
            throw ForbiddenDomainOperationException::forInvalidActor(); 
        }

        if($user->deleted_at !== null){
            if($connectedUser === null || $connectedUser['role'] !== 'ROLE_ADMIN'){
               throw new UserNotFoundException(); 
            }
        }

        return $user;
    }
}