<?php

namespace App\Blog\Infrastructure\Mapper;

use App\Blog\Domain\Entity\Article;
use App\Blog\Domain\ValueObject\ArticleContent;
use App\Blog\Domain\ValueObject\ArticleStatus;
use App\Blog\Domain\ValueObject\ArticleTitle;
use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use App\Shared\Domain\ValueObject\Id;

final class ArticleMapper
{
    /**
     * Methode pour mapper un Model Eloquant à une entité Domain
     *
     * @param ArticleModel $model
     * @return Article
     */
    public function toDomain(ArticleModel $model): Article
    {
        return new Article(
            Id::fromString($model->id),
            Id::fromString($model->user_id),
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
     * @param Article $article
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