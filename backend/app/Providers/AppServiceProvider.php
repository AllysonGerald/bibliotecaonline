<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ContactRepository;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ContactRepositoryInterface;
use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\RentalRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider responsável pelo registro de serviços e bindings de dependências.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Inicializa serviços da aplicação.
     */
    public function boot(): void
    {
    }

    /**
     * Registra serviços e bindings de dependências no container.
     * Mapeia interfaces de repositórios para suas implementações concretas.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
