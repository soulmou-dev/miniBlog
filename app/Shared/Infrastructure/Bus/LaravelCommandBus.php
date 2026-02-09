<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Support\Facades\Bus;

final class LaravelCommandBus implements CommandBus
{
    public function dispatch(object $command): void
    {
        Bus::dispatchSync($command);
    }
}