<?php

namespace App\Blog\Domain\ValueObject;

enum ArticleStatus: string
{
    case PENDING_VALIDATION = 'pending_validation';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PUBLISHED = 'published';
    case DELETED = 'deleted';

    public function value():string
    {
        return $this->value;
    }
}
