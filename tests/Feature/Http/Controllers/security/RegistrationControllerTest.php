<?php

namespace Tests\Feature\Http\Controllers\security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test positive case of user registration.
     *
     * @return void
     */
    public function testRegistrationSuccess()
    {
        $response = $this->postJson('/api/auth/registration', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], ['APP_KEY' => env('APP_KEY')]);

        // Assert response
        $response->assertStatus(201)
            ->assertJsonStructure(['success', 'user']);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }

    /**
     * Test case for registration with missing required fields.
     *
     * @return void
     */
    public function testRegistrationMissingFields()
    {
        $response = $this->postJson('/api/auth/registration', [
            'name' => 'John Doe'
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(400)
            ->assertJsonStructure(['email', 'password']);
    }

    /**
     * Test case for registration with invalid email format.
     *
     * @return void
     */
    public function testRegistrationInvalidEmail()
    {
        $response = $this->postJson('/api/auth/registration', [
            'name' => 'John Doe',
            'email' => 'invalidemail',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(400)
            ->assertJsonStructure(['email']);
    }

    /**
     * Test case for registration with password confirmation mismatch.
     *
     * @return void
     */
    public function testRegistrationPasswordMismatch()
    {
        $response = $this->postJson('/api/auth/registration', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'differentpassword',
        ], ['APP_KEY' => env('APP_KEY')]);

        $response->assertStatus(400)
            ->assertJsonStructure(['password']);
    }

    /**
     * Test case for registration when user already exists.
     *
     * @return void
     */
//    public function testRegistrationUserExists()
//    {
//        // Assuming user with email 'johndoe@example.com' already exists in the database
//        $response = $this->postJson('/api/auth/registration', [
//            'name' => 'John Doe',
//            'email' => 'johndoe@example.com',
//            'password' => 'password',
//            'password_confirmation' => 'password',
//        ], ['APP_KEY' => env('APP_KEY')]);
//
//        $response->assertStatus(422)
//            ->assertJsonStructure(['error']);
//    }
}
