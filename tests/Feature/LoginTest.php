<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_to_login_page()
    {
        $response = $this->get('admin/');

        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function a_user_can_login_with_email_and_password()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('admin/login', [
            'login' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('admin/');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function a_user_can_login_with_cpf_and_password()
    {
        $user = User::factory()->create([
            'cpf' => '12345678900',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('admin/login', [
            'login' => '12345678900',
            'password' => 'password123',
        ]);

        $response->assertRedirect('admin/');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('admin/login', [
            'login' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);

        $response->assertRedirect('/');

        $response->assertSessionHasErrors([
            'credenciais' => 'Credenciais inválidas.',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function an_authenticated_user_is_redirected_to_homepage()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('admin/');

        //$response->assertSee('Página principal');
    }

    /** @test */
    public function a_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('admin/logout');

        $response->assertRedirect('admin/login');
        $this->assertGuest();
    }
}
