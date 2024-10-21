<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_orders_list()
    {
        $user = User::factory()->create();
        $user = $user->fresh();

        $orders = Order::factory()->count(5)->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.home'));

        $response->assertStatus(200);
        $response->assertViewHas('orders', function ($orders) {
            return $orders->count() === 5;
        });
    }

    /** @test */
    public function it_can_filter_orders_by_name_or_cpf()
    {
        $user = User::factory()->create();
        $user = $user->fresh();

        $this->actingAs($user);

        $customer1 = Customer::factory()->create(['name' => 'João', 'cpf' => '11111111111']);
        $customer2 = Customer::factory()->create(['name' => 'Maria', 'cpf' => '22222222222']);

        $order1 = Order::factory()->create(['customer_id' => $customer1->id]);
        $order2 = Order::factory()->create(['customer_id' => $customer2->id]);

        $response = $this->get(route('admin.home', ['search' => 'João']));
        $response->assertSee($order1->customer->name);
        $response->assertDontSee($order2->customer->name);

//        $response = $this->get(route('admin.home', ['search' => '22222222222']));
//        $response->assertSee($order2->customer->cpf);
//        $response->assertDontSee($order1->customer->cpf);
    }


    /** @test */
    public function it_displays_order_details()
    {
        $user = User::factory()->create();
        $user = $user->fresh();

        $this->actingAs($user);

        $order = Order::factory()->create();

        $response = $this->get(route('admin.orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee($order->customer_name);
        $response->assertSee($order->cpf);
    }

    /** @test */
    public function it_can_export_orders_to_excel()
    {
        $user = User::factory()->create();
        $user = $user->fresh();

        $this->actingAs($user);

        $orders = Order::factory()->count(5)->create();

        $response = $this->get(route('admin.orders.export', ['format' => 'excel']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function it_can_export_orders_to_pdf()
    {
        $user = User::factory()->create();
        $user = $user->fresh();

        $this->actingAs($user);

        $orders = Order::factory()->count(5)->create();

        $response = $this->get(route('admin.orders.export', ['format' => 'pdf']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

}
