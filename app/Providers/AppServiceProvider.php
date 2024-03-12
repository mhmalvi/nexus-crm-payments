<?php

namespace App\Providers;

use App\Interfaces\CardDetailsInterface;
use App\Services\cardDetails\GetCardDetailsService;
use Illuminate\Support\ServiceProvider;

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
