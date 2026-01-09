<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login page can be rendered
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Đăng nhập');
    }

    /**
     * Test register page can be rendered
     */
    public function test_register_page_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Đăng ký');
    }

    /**
     * Test user can register
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'full_name' => 'New User',
            'phone' => '0901234567',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
        ]);
    }

    /**
     * Test user can login with correct credentials
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user cannot login with wrong credentials
     */
    public function test_user_cannot_login_with_wrong_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
    }

    /**
     * Test user can logout
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test authenticated user cannot access login page
     */
    public function test_authenticated_user_cannot_access_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    /**
     * Test validation error on registration
     */
    public function test_registration_validation_errors(): void
    {
        $response = $this->post('/register', [
            'username' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ]);

        $response->assertSessionHasErrors(['username', 'email', 'password']);
    }
}
