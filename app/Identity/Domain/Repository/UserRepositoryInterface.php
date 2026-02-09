<?php

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(Id $id, ?bool $includeDeleted=false): ?User;

    public function findOneByEmail(string|Email $email): ?User;
}