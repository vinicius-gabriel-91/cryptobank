<?php

namespace App\Providers;

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
        app()->bind(
            \App\Models\Api\CustomerRepositoryInterface::class,
            \App\Models\Customer\CustomerRepository::class
        );
        app()->bind(
            \App\Models\Api\BankAccountRepositoryInterface::class,
            \App\Models\BankAccount\BankAccountRepository::class
        );
        app()->bind(
            \Facade\FlareClient\Time\Time::class,
            \Facade\FlareClient\Time\SystemTime::class
        );
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
