<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //customer
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        //user
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        //transaction
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
