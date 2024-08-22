<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    /**
     * Test user login with valid credentials.
     *
     * @return void
     */
    public function testLoginUserWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'token',
            ])
            ->assertJson([
                'status' => true,
                'message' => 'User Logged In Successfully',
            ]);
    }

    /**
     * Test user login with invalid credentials.
     *
     * @return void
     */
    public function testLoginUserWithInvalidCredentials()
{
    $response = $this->postJson('/api/auth/login', [
        'email' => 'invalid@example.com',
        'password' => 'invalidpassword',
    ]);

    $response->assertStatus(401)
        ->assertJsonStructure([
            'status',
            'message',
        ])
        ->assertJson([
            'status' => false,
            'message' => 'Email & Password does not match with our record.',
        ]);
}


    /**
     * Test user logout.
     *
     * @return void
     */
    public function testLogoutUser()
    {
        // Create a user
        $user = User::factory()->create();

        // Generate a Sanctum token for the user
        $token = $user->createToken('API_TOKEN')->plainTextToken;

        // Logout the user using the API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        // Assert the response
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'User Logged Out Successfully',
                 ]);
    }
}

