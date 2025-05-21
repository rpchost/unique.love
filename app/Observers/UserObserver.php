<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Unilo\Keys\CacheKeys;

class UserObserver
{
    public function updated(User $user)
    {
        $this->clearCache($user);
    }

    public function deleted(User $user)
    {
        $this->clearCache($user);
    }

    public function pivotSynced(User $user, $relation, $changes)
    {
        if ($relation === 'roles') {
            $this->clearCache($user);
        }
    }

    protected function clearCache(User $user)
    {
        $cacheKeys = [
            CacheKeys::format(CacheKeys::USER_DATA, ['guard' => 'web', 'id' => $user->id]),
            CacheKeys::format(CacheKeys::USER_TOKEN, ['guard' => 'web', 'id' => $user->id]),
        ];
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}
