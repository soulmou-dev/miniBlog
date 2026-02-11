<?php

namespace App\Identity\Infrastructure\Persistence\Repository;

use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\Entity\User;
use App\Identity\Infrastructure\Mapper\UserMapper;
use App\Identity\Infrastructure\Persistence\Eloquent\UserModel;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

final class UserRepository implements UserRepositoryInterface
{

    public function __construct(
        private UserMapper $mapper
    ) {}

    public function save(User $user, ?string $hashedPassword = null): void
    {
        $model = UserModel::find($user->id()->value()->toString());
        $model = $this->mapper->toModel($user, $model);
        if($hashedPassword){
            $model->password = $hashedPassword;
        }
        $model->save();
    }

    public function findById(Id $id, ?bool $includeDeleted = false): ?User
    {   
        $query = $includeDeleted ? UserModel::query()->withTrashed() :  UserModel::query();
        $model = $query->findOrFail($id->value()->toString());

        return $model ? $this->mapper->toDomain($model) : null;
    }
    public function findOneByEmail(string|Email $email, ?bool $includeDeleted = false): ?User
    {
        $email = $email instanceof Email ? $email->value() : $email;

        $query =  UserModel::query()->where('email', $email);
        if($includeDeleted){
            $query->withTrashed();
        }    
        $model = $query->first();

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function existsByEmail(string|Email $email): bool
    {
        $email = $email instanceof Email ? $email->value() : $email;

        return UserModel::query()->where('email', $email)
                        ->withTrashed()
                        ->exists();
    }

    public function delete(Id $id): void
    {
        $model = UserModel::find($id->value()->toString());
        if($model){
            $model->delete();
        }
    }

    public function restore(Id $id): void
    {
        $model = UserModel::query()->where('id', $id->value()->toString())->withTrashed();
        if($model){
            $model->restore();
        }
    }

}