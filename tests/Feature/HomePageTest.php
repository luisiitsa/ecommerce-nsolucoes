<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_correctly()
    {
        Product::factory()->create([
            'name' => 'Produto 1',
            'price' => 99.99,
            'image' => 'products/produto1.jpg',
        ]);

        Product::factory()->create([
            'name' => 'Produto 2',
            'price' => 149.99,
            'image' => 'products/produto2.jpg',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Produto 1');
        $response->assertSee('R$ 99,99');
        $response->assertSee('products/produto1.jpg');

        $response->assertSee('Produto 2');
        $response->assertSee('R$ 149,99');
        $response->assertSee('products/produto2.jpg');
    }
}
