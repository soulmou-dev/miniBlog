<?php

namespace App\Identity\Infrastructure\Mapper;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\FirstName;
use App\Identity\Domain\ValueObject\LastName;
use App\Identity\Domain\ValueObject\UserRole;
use App\Identity\Infrastructure\Persistence\Eloquent\UserModel;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

final class UserMapper
{
    /**
     * Methode pour mapper un Model Eloquant à une entité Domain
     *
     * @param UserModel $model
     * @return User
     */
    public function toDomain(UserModel $model): User
    {
        return new User(
            Id::fromString($model->id),
            new Email($model->email),
            new LastName($model->lastName),
            new FirstName($model->firstName),
            UserRole::from($model->role),
            $model->creacted_at,
            $model->updated_at,
            $model->deleted_at
        );
    }

    /**
     * Methode pour mapper une entité Domain à un Model Eloquent
     *
     * @param User $user
     * @param mixed $model
     * @return void
     */
    public function toModel(User $user, ?UserModel $model = null): UserModel
    {
        $model = $model ?? new UserModel();
        
        $model->id = $user->id()->value()->toString();
        $model->email = $user->email()->value();
        $model->lastName = $user->lastName()->value();
        $model->firstName = $user->firstName()->value();
        $model->role = $user->role()->value;

        return $model;
    }
}