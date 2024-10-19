<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_user_list()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin);

        $response = $this->get('/admin/users');

        $response->assertStatus(200)
            ->assertViewHas('users');
    }

    public function test_non_admin_cannot_see_user_list()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user);

        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $newUserData = User::factory()->make(['email' => 'testuser@example.com'])->toArray()
            + ['password' => '12345678', 'password_confirmation' => '12345678'];

        $this->actingAs($admin);

        $response = $this->post('/admin/users', $newUserData);

        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);

        $response->assertRedirect('/admin/users');
    }

    public function test_admin_can_edit_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $updatedUserData = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
        ];

        $this->actingAs($admin);

        $response = $this->put("admin/users/{$user->id}", $updatedUserData);

        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
        $response->assertRedirect('admin/users');
    }

    public function test_admin_can_soft_delete_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->delete("/admin/users/{$user->id}");

        $this->assertSoftDeleted('users', ['id' => $user->id]);
        $response->assertRedirect('/admin/users');
    }
}
