<?php

namespace App\Providers;

use App\Repositories\StoreRepository;
use App\Repositories\Interfaces\StoreRepositoryInterface;
use App\Services\Interfaces\StoreServiceInterface;
use App\Services\StoreService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            StoreRepositoryInterface::class,
            StoreRepository::class
        );

        $this->app->bind(
            StoreServiceInterface::class,
            StoreService::class
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
