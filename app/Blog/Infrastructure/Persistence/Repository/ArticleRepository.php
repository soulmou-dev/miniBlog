<?php

namespace App\Blog\Infrastructure\Persistence\Repository;


use App\Blog\Domain\Entity\Article;
use App\Blog\Domain\Repository\ArticleRepositoryInterface;
use App\Blog\Infrastructure\Mapper\ArticleMapper;
use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Id;

final class ArticleRepository implements ArticleRepositoryInterface
{

    public function __construct(
        private ArticleMapper $mapper
    ) {}

    public function save(Article $article): void
    {
        $model = ArticleModel::withTrashed()->find($article->id()->value()->toString());
        $model = $this->mapper->toModel($article, $model);
       
        $model->save();
    }

    public function findById(Id $id, ?bool $includeDeleted = false): ?Article
    {   
        $query = $includeDeleted ? ArticleModel::query()->withTrashed() :  ArticleModel::query();
        $model = $query->findOrFail($id->value()->toString());

        return $model ? $this->mapper->toDomain($model) : null;
    }
    public function findOneByEmail(string|Email $email, ?bool $includeDeleted = false): ?Article
    {
        $email = $email instanceof Email ? $email->value() : $email;

        $query =  ArticleModel::query()->where('email', $email);
        if($includeDeleted){
            $query->withTrashed();
        }    
        $model = $query->first();

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function delete(Id $id): void
    {
        $model = ArticleModel::find($id->value()->toString());
        if($model){
            $model->delete();
        }
    }

    public function restore(Id $id): void
    {
        $model = ArticleModel::query()->where('id', $id->value()->toString())->withTrashed();
        if($model){
            $model->restore();
        }
    }

}