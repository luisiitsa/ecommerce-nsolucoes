<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;

class CustomerService
{
    protected CustomerRepository $customerRepository;

    /**
     * Constructor for E-commerce NSoluções application.
     *
     * @param CustomerRepository $customerRepository The customer repository used in the application.
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Registers a new customer in the E-commerce NSoluções application.
     * The 'password' field in the data array will be hashed using Laravel's Hash::make method.
     *
     * @param array $data The data array containing the information of the new customer.
     * @return Customer The newly created customer object.
     * @throws ValidatorException
     */
    public function register(array $data): Customer
    {
        $data['password'] = Hash::make($data['password']);
        return $this->customerRepository->create($data);
    }

    /**
     * Updates the customer information in the E-commerce NSoluções application.
     * If the 'password' field in the data array is not empty, it will be hashed using Laravel's Hash::make method.
     *
     * @param Customer $customer The customer object to be updated.
     * @param array $data The updated data for the customer.
     * @return Customer The updated customer object.
     */
    public function update(Customer $customer, array $data): Customer
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->customerRepository->update($data, $customer->id);
    }

    /**
     * Logs in the user with the provided credentials.
     *
     * @param array $credentials The user credentials for login
     * @return bool True if login attempt is successful, false otherwise
     */
    public function login(array $credentials): bool
    {
        return Auth::guard('customer')->attempt($credentials);
    }

    /**
     * Logs out the user from the application.
     *
     * @return null
     */
    public function logout(): null
    {
        return Auth::guard('customer')->logout();
    }
}
