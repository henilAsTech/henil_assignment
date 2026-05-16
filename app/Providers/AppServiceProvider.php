<?php

namespace App\Providers;

use App\Repositories\FamilyRepository;
use App\Repositories\Interfaces\FamilyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FamilyRepositoryInterface::class,
            FamilyRepository::class,
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
