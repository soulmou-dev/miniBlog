<?php

namespace App\Blog\Application\Command;

final class UnpublishArticleCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $authorId,
    ) {}

    public static function fromData(array $data): self
    {
        return new self(
            $data['id'],
            $data['authorId']
        );
    }
}