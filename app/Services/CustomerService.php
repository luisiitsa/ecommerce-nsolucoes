<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;

class CustomerService
{
    protected CustomerRepository $customerRepository;
    protected Client $httpClient;

    /**
     * Constructor for E-commerce NSoluções application.
     *
     * @param CustomerRepository $customerRepository The customer repository used in the application.
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->httpClient = new Client([
            'base_uri' => env('ASAAS_HOST'),
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'access_token' => env('ASAAS_SECRET_ACCESS_KEY'),
            ],
        ]);
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

        $asaasCustomerData = [
            'notificationDisabled' => true,
            'name' => $data['name'],
            'cpfCnpj' => $data['cpf'],
            'email' => $data['email'],
            'mobilePhone' => $data['cellphone'],
            'address' => $data['address'],
            'addressNumber' => $data['number'],
            'complement' => $data['complement'],
            'province' => $data['neighborhood'],
            'postalCode' => $data['postal_code'],
        ];

        try {
            $response = $this->httpClient->post('/api/v3/customers', [
                'json' => $asaasCustomerData,
            ]);

            $asaasResponse = json_decode($response->getBody(), true);

            $data['asaas_id'] = $asaasResponse['id'];

            return $this->customerRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao criar cliente no Asaas: ' . $e->getMessage());
        }
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
