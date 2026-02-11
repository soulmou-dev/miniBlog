<?php

namespace App\Blog\Application\Query;

use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;

final class GetArticleByIdHandler
{
    public function __invoke(string $id): ArticleModel
    {
        $article = ArticleModel::findOrFail($id);

        if(!$article){
            throw new ArticleNotFoundException();
        }

        return $article;
    }
}