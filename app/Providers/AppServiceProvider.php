<?php

namespace App\Providers;

use App\Identity\Application\Security\PasswordHasherInterface;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Infrastructure\Persistence\Repository\UserRepository;
use App\Identity\Infrastructure\Security\PasswordHasher;
use App\Shared\Domain\Bus\CommandBus;
use App\Shared\Infrastructure\Bus\LaravelCommandBus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\Handler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
    ExceptionHandler::class,
    Handler::class
);


        $this->app->bind(
        PasswordHasherInterface::class,
        PasswordHasher::class
        );

        $this->app->bind(
        CommandBus::class,
        LaravelCommandBus::class
        );

        $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
