<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_orders_list()
    {
        $orders = Order::factory()->count(5)->create();

        $response = $this->get(route('admin.home'));

        $response->assertStatus(200);
        $response->assertViewHas('orders', function ($orders) {
            return $orders->count() === 5;
        });
    }

    /** @test */
    public function it_can_filter_orders_by_name_or_cpf()
    {
        $order1 = Order::factory()->create(['customer_name' => 'João', 'cpf' => '11111111111']);
        $order2 = Order::factory()->create(['customer_name' => 'Maria', 'cpf' => '22222222222']);

        $response = $this->get(route('admin.home', ['search' => 'João']));
        $response->assertSee($order1->customer_name);
        $response->assertDontSee($order2->customer_name);

        $response = $this->get(route('admin.home', ['search' => '22222222222']));
        $response->assertSee($order2->cpf);
        $response->assertDontSee($order1->cpf);
    }


    /** @test */
    public function it_displays_order_details()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('admin.orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee($order->customer_name);
        $response->assertSee($order->cpf);
    }

    /** @test */
    public function it_can_export_orders_to_excel()
    {
        $orders = Order::factory()->count(5)->create();

        $response = $this->get(route('admin.orders.export', ['format' => 'excel']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function it_can_export_orders_to_pdf()
    {
        $orders = Order::factory()->count(5)->create();

        $response = $this->get(route('admin.orders.export', ['format' => 'pdf']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

}
