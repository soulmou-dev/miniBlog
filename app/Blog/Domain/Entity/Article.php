<?php

namespace App\Blog\Domain\Entity;

use App\Blog\Domain\Exception\InvalidArticleStatusTransitionException;
use App\Blog\Domain\ValueObject\ArticleContent;
use App\Blog\Domain\ValueObject\ArticleStatus;
use App\Blog\Domain\ValueObject\ArticleTitle;
use App\Shared\Domain\Exception\ForbiddenDomainOperationException;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;

final class Article
{
    private Id $id;
    private Id $userId;
    private ArticleTitle $title;
    private ArticleContent $content;
    private ArticleStatus $status;
    private ?DateTimeImmutable $createdAt = null;
    private ?DateTimeImmutable $publishedAt = null;
    private ?DateTimeImmutable $updatedAt = null;
    private ?DateTimeImmutable $deletedAt = null;

    public function __construct(
        Id $id,
        Id $userId,
        ArticleTitle $title,
        ArticleContent $content,
        ?ArticleStatus $status = ArticleStatus::PENDING_VALIDATION,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $publishedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $updatedAt;
        $this->publishedAt = $publishedAt;
        $this->deletedAt = $deletedAt;

    }

    public function id():Id
    {
        return $this->id;
    }

    public function userId(): Id
    {
        return $this->userId;
    }

    public function title(): ArticleTitle
    {
        return $this->title;
    }

    public function content(): ArticleContent
    {
        return $this->content;
    }

    public function status(): ArticleStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function update(
        ArticleTitle $title,
        ArticleContent $content
    ): void {
        $this->title = $title;
        $this->content = $content;
        $this->status = ArticleStatus::PENDING_VALIDATION;
        $this->touch(); // met à jour updatedAt
    }


    public function delete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
        $this->status = ArticleStatus::DELETED;
        $this->touch(); // met à jour updatedAt
    }

    public function restore(): void
    {
        if($this->isDeleted()===false){
            throw new InvalidArticleStatusTransitionException('L\'article n\'est pas supprimé');
        }

        if($this->isPublished()){
            $this->status = ArticleStatus::PUBLISHED;
        }else{
            $this->status = ArticleStatus::PENDING_VALIDATION; 
        }   

        $this->deletedAt = null;        
        $this->touch(); // met à jour updatedAt
    }

    public function approve(): void
    {
        if($this->status === ArticleStatus::APPROVED) {
            throw new InvalidArticleStatusTransitionException(
                'L\'article est déjà approuvé'
            );
        }

        if($this->status === ArticleStatus::DELETED) {
            throw new InvalidArticleStatusTransitionException(
                'Impossible d\'approuver un article supprimé.'
            );
        }

        $this->status = ArticleStatus::APPROVED;
        $this->touch(); // met à jour updatedAt
    }

    public function reject(): void
    {
        if($this->isRejected()) {
            throw new InvalidArticleStatusTransitionException(
                'L\'article est déjà rejeté.'
            );
        }

        if($this->isDeleted()) {
            throw new InvalidArticleStatusTransitionException(
                'Impossible de rejeter un article supprimé.'
            );
        }

        $this->status = ArticleStatus::REJECTED;
        $this->touch(); // met à jour updatedAt
    }

    public function publish(): void
    {
        if($this->isApproved() === false) {
            throw new InvalidArticleStatusTransitionException(
                "Impossible de publier un article non approuvé"
            );
        }

        $this->status = ArticleStatus::PUBLISHED;
        $this->publishedAt = new DateTimeImmutable();
        $this->touch(); // met à jour updatedAt
    }

    public function unpublish(): void
    {
        $this->status = ArticleStatus::APPROVED;
        $this->publishedAt = null;
        $this->touch(); // met à jour updatedAt
    }

    public function assertOwnedBy(?Id $userId):void
    { 
        if ($userId === null || $this->userId->equals($userId)===false) {
            throw ForbiddenDomainOperationException::forOwnershipViolation();
        }
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function isPublished(): bool
    {
        return $this->publishedAt !== null;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function isPending(): bool
    {
        return $this->status === ArticleStatus::PENDING_VALIDATION;
    }

    public function isApproved(): bool
    {
        return $this->status === ArticleStatus::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === ArticleStatus::REJECTED;
    }
}
