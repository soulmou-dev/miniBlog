<?php

namespace App\Identity\Application\Query;

use App\Identity\Domain\Exception\UserNotFoundException;
use App\Identity\Infrastructure\Persistence\Eloquent\UserModel;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;

final class GetUserByIdHandler
{
    public function __invoke(string $id): UserModel
    {
        $user = UserModel::findOrFail($id);

        if(!$user){
            throw new UserNotFoundException();
        }

        return $user;
    }
}