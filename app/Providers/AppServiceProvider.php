<?php

namespace App\Providers;

use App\Interfaces\CableModemRepositoryInterface;
use App\Interfaces\ModelRepositoryInterface;
use App\Repositories\CableModemRepository;
use App\Repositories\ModelRepository;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->app->bind(CableModemRepositoryInterface::class, CableModemRepository::class);
      
      $this->app->bind(ModelRepositoryInterface::class, ModelRepository::class);
    }
}
