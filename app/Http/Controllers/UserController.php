<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application {
        $users = $this->userService->search();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->userService->find($user->id));
    }

    public function store(CreateUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->userService->create($request->validated());
        return redirect()->route('admin.users.index');
    }

    public function create(
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.users.create');
    }

    public function edit($id
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application {
        $user = $this->userService->find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $this->userService->update($user->id, $request->validated());
        return redirect()->route('admin.users.index');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user()->isAdmin()) {
            $this->userService->delete($id);
            return redirect()->route('admin.users.index');
        }

        return abort(403, 'Usuário não possui autorização para essa ação');
    }
}
