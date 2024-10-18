<?php

namespace App\User\Infrastructure\Providers;

use App\User\Application\Mappers\UserMapperInterface;
use App\User\Domain\Repositories\UserRepositoryInterface;
use App\User\Infrastructure\Mappers\UserMapper;
use App\User\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);

        $this->app->bind(UserMapperInterface::class, UserMapper::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../Presentation/Routes/api.php');
    }
}
