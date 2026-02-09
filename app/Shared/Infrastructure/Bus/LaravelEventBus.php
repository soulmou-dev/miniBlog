<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\EventBus;
use Illuminate\Support\Facades\Bus;

final class LaravelCommandBus implements EventBus
{
    public function publish(object $event): void
    {
        Bus::dispatch($event);
    }
}