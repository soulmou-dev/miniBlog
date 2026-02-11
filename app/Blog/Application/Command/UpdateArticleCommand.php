<?php

namespace App\Blog\Application\Command;

final class UpdateArticleCommand
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly string $id,
        public readonly string $authorId,
        public readonly string $role
    ) {}

    public static function fromData(array $data): self
    {
        return new self(
            $data['title'],
            $data['content'],
            $data['id'],
            $data['authorId'],
            $data['role'],
        );
    }
}