<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\PriceCalculationService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EntityManagerInterface::class, fn($app) => $app->get('em'));

        $this->app->singleton(PriceCalculationService::class, function ($app) {
            return new PriceCalculationService($app->make(EntityManagerInterface::class));
        });
    }

    public function boot(): void
    {
        //
    }
}