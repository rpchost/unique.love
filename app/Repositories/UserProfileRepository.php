<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Unilo\Keys\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\CacheKeyFormatter;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function __construct(
        private readonly User $model,
        private readonly CacheKeyFormatter $keyFormatter
    ) {
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function add(array $attributes): User
    {
        return $this->model->create($attributes);
    }

    public function edit($id, array $attributes)
    {
        $result = $this->model->where('id', $id)->update($attributes) > 0;
        if ($result) {
            $this->clearCache($id);
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->model->destroy($id) > 0;
        if ($result) {
            $this->clearCache($id);
        }
        return $result;
    }

    protected function clearCache(int $id, array $guards = ['web', 'api']): void
    {
        $cacheKeys = [];
        foreach ($guards as $guard) {
            $cacheKeys[] = $this->keyFormatter->format(CacheKeys::USER_DATA, ['guard' => $guard, 'id' => (string) $id]);
            $cacheKeys[] = $this->keyFormatter->format(CacheKeys::USER_TOKEN, ['guard' => $guard, 'id' => (string) $id]);
        }

        foreach ($cacheKeys as $key) {
            try {
                Cache::forget($key);
            } catch (InvalidArgumentException $e) {
                Log::error('Failed to clear cache', ['key' => $key, 'error' => $e->getMessage()]);
            }
        }
    }
}
