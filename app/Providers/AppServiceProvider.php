<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Protocols\OrderFilterInterface;
use App\DataFilters\OrderFilter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Регистрация сервисов
     */
    public function register(): void
    {
        $this->app->bind(
            OrderFilterInterface::class,
            OrderFilter::class
        );
    }

    /**
     * Стартовая загрузка сервисов
     */
    public function boot(): void
    {
        //
    }
}
