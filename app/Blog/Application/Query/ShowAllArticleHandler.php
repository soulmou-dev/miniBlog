<?php

namespace App\Blog\Application\Query;

use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
final class ShowAllArticleHandler
{
    public function __invoke(?array $connectedUser = null): ?Collection
    {
         $query = ArticleModel::query()
            ->select('articles.*', DB::raw("CONCAT(users.lastName,' ', users.firstName) as authorName"))
            ->join('users', 'users.id', '=', 'articles.user_id')
            ->orderByRaw("
                CASE
                    WHEN status = 'pending_validation' THEN 0
                    ELSE 1
                END
            ");
        
        if($connectedUser === null OR $connectedUser['role'] === 'ROLE_ADMIN'){
            $query->withTrashed();
        }

        $articles = $query->get();
        return $articles;
    }
}