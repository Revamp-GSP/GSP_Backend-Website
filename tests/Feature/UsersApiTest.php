<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_users()
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'is_admin', 'role', 'created_at', 'updated_at']
            ]
        ]);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $userData = [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'is_admin' => true,
            'role' => 'admin'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'User created successfully.']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com', // Pastikan email ini unik atau sama dengan email pengguna yang sedang diperbarui
            'password' => 'newpassword',
            'is_admin' => true,
            'role' => 'admin'
        ];

        $response = $this->putJson('/api/users/' . $user->id, $updateData);

        // Tambahkan baris berikut untuk melihat respon API
        $response->dump();

        $response->assertStatus(200);
        $response->assertJson(['message' => 'User updated successfully.']);

        $this->assertDatabaseHas('users', [
            'email' => 'updated@example.com'
        ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'User deleted successfully.']);

        $this->assertDeleted($user);
    }
}
