<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CardDetailsInterface;
use App\Services\CardDetailsInsertService;
use App\Interfaces\InsertCardDetailsInterface;
use App\Services\cardDetails\GetCardDetailsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CardDetailsInterface::class, GetCardDetailsService::class);
        $this->app->singleton(InsertCardDetailsInterface::class, CardDetailsInsertService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
