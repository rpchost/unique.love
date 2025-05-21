<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Services\CacheKeyFormatter;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Unilo\Keys\CacheKeys;

/**
 * Custom user provider with caching for Eloquent models.
 */
class CachedEloquentUserProvider extends EloquentUserProvider
{
    public function __construct(
        $hasher,
        string $model,
        private readonly UserProfileRepositoryInterface $userRepository,
        private readonly CacheKeyFormatter $keyFormatter
    ) {
        parent::__construct($hasher, $model);
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        $cacheKey = $this->keyFormatter->format(CacheKeys::USER_DATA, [
            'guard' => $this->getGuard(),
            'id' => (string) $identifier,
        ]);

        try {
            return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($identifier) {
                $user = $this->userRepository->find((int) $identifier);
                if ($user instanceof User) {
                    $user->load('roles');
                    Log::info('User roles loaded from database', ['identifier' => $identifier]);
                } elseif ($user) {
                    Log::warning('User is not an Eloquent model', [
                        'type' => get_class($user),
                        'identifier' => $identifier,
                    ]);
                }
                return $user;
            });
        } catch (\Exception $e) {
            Log::error('Failed to retrieve user from cache', [
                'key' => $cacheKey,
                'identifier' => $identifier,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        $cacheKey = $this->keyFormatter->format(CacheKeys::USER_DATA, [
            'guard' => $this->getGuard(),
            'id' => (string) $identifier,
        ]);

        try {
            return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($identifier, $token) {
                $user = parent::retrieveByToken($identifier, $token);
                if ($user) {
                    Log::info('User token retrieved from database', ['identifier' => $identifier]);
                }
                return $user;
            });
        } catch (\Exception $e) {
            Log::error('Failed to retrieve token from cache', [
                'key' => $cacheKey,
                'identifier' => $identifier,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Get the current authentication guard.
     *
     * @return string
     */
    protected function getGuard(): string
    {
        return request()->route()->getAction('guard') ?? 'web';
    }
}
