<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;

    /**
     *
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Displays the login form for the E-commerce NSoluções application.
     *
     * If the user is already authenticated, redirects to the admin dashboard route.
     * Otherwise, returns the view for the admin login page.
     */
    public function loginForm(
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.home');
        }

        return view('admin.login');
    }

    /**
     * Handles the login process for the user.
     *
     * @param LoginRequest $request The login request containing user credentials.
     * @return RedirectResponse Redirects the user to the dashboard if login is successful, otherwise redirects back with errors.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('login', 'password');

        if ($this->authService->attemptLogin($credentials)) {
            return redirect()->route('admin.home');
        }

        return back()->withErrors(['credenciais' => 'Credenciais inválidas.'])->withInput();
    }

    /**
     * Logs out the currently authenticated user from the E-commerce NSoluções application.
     *
     * Logs out the currently authenticated user by calling the Auth::logout() method.
     * Redirects the user to the admin login route after successful logout.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
