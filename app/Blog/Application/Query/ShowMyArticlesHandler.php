<?php

namespace App\Blog\Application\Query;

use App\Blog\Infrastructure\Persistence\Eloquent\ArticleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
final class ShowMyArticlesHandler
{
    public function __invoke(string $userId): ?Collection
    {
            return ArticleModel::query()
            ->select('articles.*')
            ->where('user_id', '=',$userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}