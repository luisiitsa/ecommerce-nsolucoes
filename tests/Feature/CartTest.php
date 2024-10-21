<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_a_product_to_the_cart()
    {
        $productData = [
            'product_id' => 1,
            'product_name' => 'Produto Teste',
            'product_price' => 100.00,
        ];

        $response = $this->post('/cart/add', $productData);

        $response->assertStatus(302);
        $response->assertSessionHas('cart');

        $this->assertEquals(session('cart')[$productData['product_id']]['name'], 'Produto Teste');
        $this->assertEquals(session('cart')[$productData['product_id']]['price'], 100.00);
        $this->assertEquals(session('cart')[$productData['product_id']]['quantity'], 1);
    }

    /** @test */
    public function it_can_add_a_product_and_finish_sale()
    {
        $productData = [
            'product_id' => 1,
            'product_name' => 'Produto Teste',
            'product_price' => 100.00,
        ];

        $response = $this->post('/cart/sale', $productData);

        $response->assertStatus(302);
        $response->assertRedirect(route('app.cart'));
        $response->assertSessionHas('cart');

        $this->assertEquals(session('cart')[$productData['product_id']]['name'], 'Produto Teste');
        $this->assertEquals(session('cart')[$productData['product_id']]['price'], 100.00);
        $this->assertEquals(session('cart')[$productData['product_id']]['quantity'], 1);
    }

    /** @test */
    public function it_can_increase_the_quantity_if_product_already_in_cart()
    {
        $productData = [
            'product_id' => 1,
            'product_name' => 'Produto Teste',
            'product_price' => 100.00,
        ];

        $this->post('/cart/add', $productData);

        $this->post('/cart/add', $productData);

        $this->assertEquals(session('cart')[$productData['product_id']]['quantity'], 2);
    }

    /** @test */
    public function it_can_remove_a_product_from_the_cart()
    {
        $productData = [
            'product_id' => 1,
            'product_name' => 'Produto Teste',
            'product_price' => 100.00,
        ];

        $this->post('/cart/add', $productData);

        $this->assertEquals(session('cart')[$productData['product_id']]['name'], 'Produto Teste');

        $response = $this->post('/cart/remove', ['product_id' => $productData['product_id']]);

        $response->assertStatus(302);

        $this->assertFalse(isset(session('cart')[$productData['product_id']]));
    }
}
