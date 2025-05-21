<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\Interfaces\UserSearchRepositoryInterface;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserSearchRepository;
use App\Services\CacheKeyFormatter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserProfileRepositoryInterface::class, UserProfileRepository::class);
        $this->app->bind(UserSearchRepositoryInterface::class, UserSearchRepository::class);
        $this->app->singleton(CacheKeyFormatter::class, function () {
                return new CacheKeyFormatter();
        });
    }

    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
