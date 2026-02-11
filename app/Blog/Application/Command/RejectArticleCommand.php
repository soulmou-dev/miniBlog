<?php

namespace App\Blog\Application\Command;

final class RejectArticleCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $authorId,
        public readonly string $role
    ) {}

    public static function fromData(array $data): self
    {
        return new self(
            $data['id'],
            $data['authorId'],
            $data['role'],
        );
    }
}