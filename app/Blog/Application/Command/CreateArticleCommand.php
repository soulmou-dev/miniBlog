<?php

namespace App\Blog\Application\Command;

final class CreateArticleCommand
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly string $authorId
    ) {}

    public static function fromData(array $data): self
    {
        return new self(
            $data['title'],
            $data['content'],
            $data['authorId'],
        );
    }
}