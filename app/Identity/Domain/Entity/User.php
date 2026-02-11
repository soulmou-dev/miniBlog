<?php

namespace App\Identity\Domain\Entity;

use App\Identity\Domain\ValueObject\FirstName;
use App\Identity\Domain\ValueObject\LastName;
use App\Identity\Domain\ValueObject\UserRole;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;

final class User
{
    private Id $id;
    private Email $email;
    private LastName $lastName;
    private FirstName $firstName;
    private UserRole $role;
    private ?DateTimeImmutable $createdAt = null;
    private ?DateTimeImmutable $updatedAt = null;
    private ?DateTimeImmutable $deletedAt = null;

    public function __construct(
        Id $id,
        Email $email,
        LastName $lastName,
        FirstName $firstName,
        UserRole $role,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->role = $role;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function id():Id
    {
        return $this->id;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function update(
        LastName $lastName,
        FirstName $firstName
    ): void {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->touch(); // met à jour updatedAt
    }


    public function delete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
        $this->touch(); // met à jour updatedAt
    }

    public function restore(): void
    {
        $this->deletedAt = null;
        $this->touch(); // met à jour updatedAt
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

}