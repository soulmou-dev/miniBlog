<?php

namespace App\Shared\Domain\Bus;

interface EventBus
{
    public function publish(object $event): void;
}