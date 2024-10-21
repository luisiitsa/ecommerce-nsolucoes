<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function showRegistrationForm(
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('app.customers.register');
    }

    public function register(CreateCustomerRequest $request
    ): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $this->customerService->register($request->validated());
        return redirect('/');
    }

    public function edit(Customer $customer
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application {
        return view('app.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer
    ): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $this->customerService->update($customer, $request->validated());
        return redirect('/');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if ($this->customerService->login($credentials)) {
            return redirect()->back();
        }

        return back()->withErrors(['credenciais' => 'As credenciais fornecidas não correspondem aos nossos registros.']
        );
    }

    public function logout(
    ): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $this->customerService->logout();
        return redirect(route('app.home'));
    }
}
