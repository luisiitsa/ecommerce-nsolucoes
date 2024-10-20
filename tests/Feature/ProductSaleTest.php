<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSaleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_product_details_and_add_to_cart_button()
    {
        $product = Product::factory()->create([
            'name' => 'Camiseta',
            'price' => 99.90,
        ]);

        $response = $this->get('sales/' . $product->id);

        $response->assertStatus(200);

        $response->assertSee('Camiseta');
        $response->assertSee('R$ 99,90');
        $response->assertSee('Adicionar ao carrinho');
    }
}
