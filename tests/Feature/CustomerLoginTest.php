<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_customer_can_log_in_with_valid_credentials()
    {
        $customer = Customer::factory()->create([
            'email' => 'test@customer.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/customer/login', [
            'email' => 'test@customer.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($customer, 'customer');
    }

    /** @test */
    public function a_customer_cannot_log_in_with_invalid_credentials()
    {
        Customer::factory()->create([
            'email' => 'test@customer.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/customer/login', [
            'email' => 'test@customer.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $this->assertGuest('customer');
    }

    /** @test */
    public function a_customer_can_log_out()
    {
        $customer = Customer::factory()->create();

        $this->actingAs($customer, 'customer');

        $this->assertAuthenticatedAs($customer, 'customer');

        $response = $this->post('/customer/logout');

        $this->assertGuest('customer');

        $response->assertRedirect(route('app.home'));
    }
}
