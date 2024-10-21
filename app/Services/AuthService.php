<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * UserRepository instance for handling user data.
     */
    protected UserRepository $userRepository;

    /**
     * Constructs a new instance of the E-commerce NSoluções application.
     *
     * @param UserRepository $userRepository The user repository to be injected into the application
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Attempt to login the user using the provided credentials.
     *
     * @param array $credentials An associative array containing the login credentials, including 'login' and 'password'.
     * @return bool True if the login attempt was successful, false otherwise.
     */
    public function attemptLogin(array $credentials): bool
    {
        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'cpf';
        $user = $this->userRepository->findByLogin($credentials['login'], $loginType);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return true;
        }

        return false;
    }
}
