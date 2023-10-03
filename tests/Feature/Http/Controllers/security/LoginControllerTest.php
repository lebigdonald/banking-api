<?php

namespace Tests\Feature\Http\Controllers\security;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * Positive test case for successful login.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * Negative test case for invalid email.
     *
     * @return void
     */
    public function testLoginInvalidEmail()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid_email',
            'password' => 'password'
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(400)
            ->assertJsonStructure(['email']);
    }

    /**
     * Negative test case for invalid password.
     *
     * @return void
     */
    public function testLoginInvalidPassword()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'johndoe@example.com',
            'password' => 'p12'
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(400)
            ->assertJsonStructure(['password']);
    }

    /**
     * Negative test case for non-existing user.
     *
     * @return void
     */
    public function testLoginNonExistingUser()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexisting@example.com',
            'password' => 'password123',
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(404)
            ->assertJsonStructure(['error']);
    }

    /**
     * Negative test case for incorrect password.
     *
     * @return void
     */
    public function testLoginIncorrectPassword()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(404)
            ->assertJsonStructure(['error']);
    }
}
