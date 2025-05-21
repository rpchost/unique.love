<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Services\CacheKeyFormatter;
use App\Services\UserProfileService;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
       //User::class => UserPolicy::class,
    ];
    public function boot()
    {
        Log::info('HELLO1');
        $this->registerPolicies();
        Auth::provider('cached-eloquent', function ($app, array $config) {

            Log::info('HELLO2', ['config' => $config]);
            return new CachedEloquentUserProvider(
                hasher: $app['hash'],
                model: $config['model'],
                userRepository: $app->make(UserProfileRepositoryInterface::class),
                keyFormatter: $app->make(CacheKeyFormatter::class)
            );
        });
    }
}
