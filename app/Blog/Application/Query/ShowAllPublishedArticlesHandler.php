<?php

namespace App\Blog\Application\Query;

use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
final class ShowAllPublishedArticlesHandler
{
    public function __invoke(): ?Collection
    {
        return ArticleModel::query()
            ->select('articles.*', DB::raw("CONCAT(users.lastName,' ', users.firstName) as authorName"))
            ->join('users', 'users.id', '=', 'articles.user_id')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}