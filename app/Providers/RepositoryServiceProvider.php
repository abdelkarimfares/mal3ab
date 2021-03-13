<?php

namespace App\Providers;

use App\Repository\AccountRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\AccountRepository;
use App\Repository\Eloquent\TerrainRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\TerrainRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
       $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
       $this->app->bind(TerrainRepositoryInterface::class, TerrainRepository::class);
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
