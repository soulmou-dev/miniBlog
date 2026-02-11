<?php

namespace App\Identity\Application\Query;

use App\Identity\Infrastructure\Persistence\Eloquent\UserModel;
use Illuminate\Database\Eloquent\Collection;
final class ShowAllUsersHandler
{
    public function __invoke(): ?Collection
    {

        return UserModel::withCount('articles')
                        ->where('role', '!=', 'ROLE_ADMIN')
                        ->orderBy('created_at', 'desc')
                        ->get();
    }
}