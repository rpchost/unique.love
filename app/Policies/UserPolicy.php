<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can search users.
     */
    public function search(User $user)
    {
        return $user->hasRole('admin');
    }
}
