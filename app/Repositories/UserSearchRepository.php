<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserSearchRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class UserSearchRepository implements UserSearchRepositoryInterface
{
    public function __construct(
        private readonly User $model
    ) {
    }

    public function getByRole(string $role, int $perPage = 20)
    {
        return DB::table('users')
            ->select('users.id', 'users.name', 'users.email')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', $role)
            ->paginate($perPage);
    }

    public function search(array $criteria, int $perPage = 20)
    {
        $query = DB::table('users')
            ->select('users.id', 'users.name', 'users.email');

        if (isset($criteria['name']) && !empty(trim($criteria['name']))) {
            $query->where('name', 'like', '%' . trim($criteria['name']) . '%');
        }

        if (isset($criteria['role'])) {
            $query->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                  ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                  ->where('roles.name', $criteria['role']);
        }

        if (isset($criteria['active'])) {
            $query->where('active', $criteria['active']);
        }

        return $query->paginate($perPage);
    }

    public function getActiveUsers(): Collection
    {
        $users = DB::table('users')
                    ->select('id', 'name', 'email')
                    ->where('active', 1)
                    ->get();
        return $users;
    }
}
