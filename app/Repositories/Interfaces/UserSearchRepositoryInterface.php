<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface UserSearchRepositoryInterface
{
    public function getByRole(string $role, int $perPage = 20);
    public function search(array $criteria, int $perPage = 20);
    public function getActiveUsers(): Collection;
}
