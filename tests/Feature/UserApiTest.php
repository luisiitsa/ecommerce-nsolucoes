<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_user_data()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        $user = User::factory()->create([
            'name' => 'John Doe',
            'cpf' => '12345678900',
            'email' => 'john@example.com',
            'is_admin' => false,
        ]);

        $response = $this->getJson(route('api.users.show', $user->id));

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => 'John Doe',
            'cpf' => '12345678900',
            'email' => 'john@example.com',
            'is_admin' => false,
        ]);
    }
}
