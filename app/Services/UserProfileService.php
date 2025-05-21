<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserProfileRepositoryInterface;

class UserProfileService
{
    protected $userRepository;

    public function __construct(private LoggerInterface $logger, UserProfileRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function addUser(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->add($data);
    }

    public function editUser($id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->edit($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
