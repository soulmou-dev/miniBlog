<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Support\Facades\Bus;
use Illuminate\Container\Container;

final class LaravelCommandBus implements CommandBus
{
    public function __construct(private Container $container) {}

    public function dispatch(object $command): void
    {
        // Déterminer le Handler correspondant
        $handlerClass = str_replace('Command', 'Handler', get_class($command));

        // Récupérer le Handler via le container (injection automatique)
        $handler = $this->container->make($handlerClass);

        // Créer un Job Laravel inline pour utiliser dispatchSync
        $job = new class($handler, $command) {
            public function __construct(private $handler, private $command) {}
            public function handle() {
                ($this->handler)($this->command);
            }
        };

        //Exécuter le job via Laravel Bus::dispatchSync
        Bus::dispatchSync($job);
    }
}