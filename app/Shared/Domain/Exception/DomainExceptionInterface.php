<?php
namespace App\Shared\Domain\Exception;

interface DomainExceptionInterface
{
    public function getMessage(): string;
    public function getErrorCode(): string;
    public function reason(): string;
}