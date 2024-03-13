<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CardDetailsInterface;
use App\Services\CardDetailsInsertService;
use App\Interfaces\InsertCardDetailsInterface;
use App\Interfaces\StripeInterface;
use App\Services\cardDetails\GetCardDetailsService;
use App\Services\stripe\CreateCustomerService;

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
        $this->app->singleton(StripeInterface::class, CreateCustomerService::class);
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
