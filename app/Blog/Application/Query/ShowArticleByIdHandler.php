<?php

namespace App\Blog\Application\Query;

use App\Blog\Domain\Exception\ArticleNotFoundException;
use App\Blog\Domain\ValueObject\ArticleStatus;
use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use Illuminate\Support\Facades\DB;

final class ShowArticleByIdHandler
{
    public function __invoke(string $id, ?array $connectedUser = null): ArticleModel
    {
        $article = $query = ArticleModel::query()
            ->select('articles.*', DB::raw("CONCAT(users.lastName,' ', users.firstName) as authorName"))
            ->join('users', 'users.id', '=', 'articles.user_id')
            ->where('articles.id', $id)
            ->withTrashed()->first();

        if(!$article){
            throw new ArticleNotFoundException();
        }
        if($article->status === ArticleStatus::DELETED->value){
            if($connectedUser === null || $connectedUser['role'] !== 'ROLE_ADMIN'){
               throw new ArticleNotFoundException(); 
            }
        }

        if($connectedUser === null AND $article->status !== ArticleStatus::PUBLISHED->value ){ 
            throw new ArticleNotFoundException();
        } 

        return $article;
    }
}