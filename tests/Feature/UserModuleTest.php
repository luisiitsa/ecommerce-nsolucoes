<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModuleTest extends TestCase
{
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
}
