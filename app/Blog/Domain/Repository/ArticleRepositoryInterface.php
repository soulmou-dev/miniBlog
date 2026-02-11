<?php

namespace App\Blog\Domain\Repository;

use App\Blog\Domain\Entity\Article;
use App\Shared\Domain\ValueObject\Id;

interface ArticleRepositoryInterface
{
    public function save(Article $article): void;

    public function findById(Id $id, ?bool $includeDeleted=false): ?Article;

    public function delete(Id $id): void;

    public function restore(Id $id): void;

}