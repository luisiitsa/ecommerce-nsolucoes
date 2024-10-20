<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_products()
    {
        $this->actingAs($this->user);

        Product::factory()->count(3)->create();

        $response = $this->get('admin/products');

        $response->assertStatus(200);
        $response->assertSee('Listagem de Produtos');
    }

    /** @test */
    public function it_can_access_create_product_page()
    {
        $this->actingAs($this->user);

        $response = $this->get('admin/products/create');

        $response->assertStatus(200);
        $response->assertSee('Criar Produto');
    }

    /** @test */
    public function it_can_access_edit_product_page()
    {
        $this->actingAs($this->user);

        $product = Product::factory()->create();

        $response = $this->get("admin/products/{$product->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Editar Produto');
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $this->actingAs($this->user);

        $productData = [
            'name' => 'New Product',
            'price' => 199.99,
            'height' => 10.0,
            'width' => 5.0,
            'length' => 15.0,
            'weight' => 2.5,
        ];

        $response = $this->post('admin/products', $productData);

        $response->assertRedirect('admin/products');
        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $this->actingAs($this->user);

        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'price' => 299.99,
            'height' => 12.0,
            'width' => 6.0,
            'length' => 18.0,
            'weight' => 3.0,
        ];

        $response = $this->put("admin/products/{$product->id}", $updatedData);

        $response->assertRedirect('admin/products');
        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    /** @test */
    public function it_deletes_the_product()
    {
        $this->actingAs($this->user);

        $product = Product::factory()->create();

        $response = $this->delete("admin/products/{$product->id}");

        $response->assertRedirect('admin/products');
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user = $this->user->fresh();
    }
}
