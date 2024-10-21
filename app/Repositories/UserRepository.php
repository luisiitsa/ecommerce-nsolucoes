<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Finds a user by their login credentials.
     *
     * @param string $login The user's login credential.
     * @param string $loginType The type of login credential to search by.
     * @return User|null The user object if found, null otherwise.
     */
    public function findByLogin(string $login, string $loginType): ?User
    {
        return User::where($loginType, $login)->first();
    }
}
