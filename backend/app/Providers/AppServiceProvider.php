<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use App\Repositories\RentalRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
