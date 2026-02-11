<?php

namespace App\Blog\Infrastructure\Mapper;

use App\Blog\Domain\Entity\Article;
use App\Blog\Domain\ValueObject\ArticleContent;
use App\Blog\Domain\ValueObject\ArticleStatus;
use App\Blog\Domain\ValueObject\ArticleTitle;
use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\FirstName;
use App\Identity\Domain\ValueObject\LastName;
use App\Identity\Domain\ValueObject\UserRole;
use App\Identity\Infrastructure\Persistence\Eloquent\ArticleModel;
use App\Identity\Infrastructure\Persistence\Eloquent\UserModel;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

final class ArticleMapper
{
    /**
     * Methode pour mapper un Model Eloquant à une entité Domain
     *
     * @param UserModel $model
     * @return User
     */
    public function toDomain(ArticleModel $model): Article
    {
        return new Article(
            Id::fromString($model->id),
            new Id($model->user_id),
            new ArticleTitle($model->title),
            new ArticleContent($model->content),
            ArticleStatus::from($model->status),
            $model->creacted_at,
            $model->updated_at,
            $model->published_at,
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
    public function toModel(Article $article, ?ArticleModel $model = null): ArticleModel
    {
        $model = $model ?? new ArticleModel();
        
        $model->id = $article->id()->value()->toString();
        $model->user_id = $article->userId()->value()->toString();
        $model->title = $article->title()->value();
        $model->content = $article->content()->value();
        $model->status = $article->status()->value;
        $model->published_at = $article->getPublishedAt();

        return $model;
    }
}