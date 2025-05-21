<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserSearchRepositoryInterface;

class UserSearchService
{
    protected $userRepository;

    public function __construct(private LoggerInterface $logger, UserSearchRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function searchUsers(array $criteria)
    {
        $user = Auth::guard('web')->user();
        $this->logger->notice('Fetched user {name}', [
            'name' => $user ? $user->name : 'not found']);

        $userData = [
            'id' => $user->id,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
        ];

        $userId = $userData['id'] ?? null;
        $this->logger->info('UserService: search called', ['user_id' => $userId]);
        return $this->userRepository->search($criteria);
    }
}
