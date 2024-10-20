<?php

namespace Tests\Feature;

use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /** @test */
    public function test_customer_can_be_created()
    {
        $response = $this->post('/customers', [
            'name' => 'John Doe',
            'postal_code' => '12345-678',
            'address' => '123 Main St',
            'number' => '101',
            'complement' => 'Apt 1',
            'neighborhood' => 'Downtown',
            'city' => 'Sample City',
            'state' => 'SP',
            'cellphone' => '(11) 91234-5678',
            'email' => 'john@example.com',
            'password' => '12345678',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('customers', ['email' => 'john@example.com']);
    }

    /** @test */
    public function test_customer_can_be_updated()
    {
        $customer = Customer::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $response = $this->put("/customers/{$customer->id}", [
            'name' => 'Jane Updated',
            'postal_code' => '87654-321',
            'address' => '321 Main St',
            'number' => '202',
            'complement' => 'Apt 2',
            'neighborhood' => 'Uptown',
            'city' => 'Updated City',
            'state' => 'RJ',
            'cellphone' => '(21) 98765-4321',
            'email' => 'janeupdated@example.com',
            'password' => bcrypt('newpassword'),
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('customers', ['email' => 'janeupdated@example.com']);
    }
}
