<?php

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

interface UserRepositoryInterface
{
    public function save(User $user, ?string $hashedPassword = null): void;

    public function findById(Id $id, ?bool $includeDeleted=false): ?User;

    public function findOneByEmail(string|Email $email): ?User;

    public function existsByEmail(string|Email $email): bool;

    public function delete(Id $id): void;

    public function restore(Id $id): void;
}