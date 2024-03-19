<?php

namespace App\Providers;

use App\Repositories\EloquentItemRepository;
use App\Repositories\ItemRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryBindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ItemRepositoryInterface::class, EloquentItemRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
