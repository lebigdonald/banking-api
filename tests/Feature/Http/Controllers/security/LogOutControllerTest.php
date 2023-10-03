<?php

namespace Tests\Feature\Http\Controllers\security;

use Tests\TestCase;

class LogOutControllerTest extends TestCase
{
    /**
     * Test user logout with valid email and logged-in user.
     *
     * @return void
     */
    public function testUserLogoutWithValidEmailAndLoggedInUser()
    {
        $response = $this->postJson('/api/auth/logout', [
            'email' => 'johndoe@example.com'
        ], ['APP_KEY' => env('APP_KEY')]);

        // Assert response
        $response->assertStatus(200)
            ->assertJsonStructure(['success']);
    }

    /**
     * Test user logout with valid email and not logged-in user.
     *
     * @return void
     */
    public function testUserLogoutWithValidEmailAndNotLoggedInUser()
    {
        $response = $this->postJson('/api/auth/logout', [
            'email' => 'johndoe@example.com'
        ], ['APP_KEY' => env('APP_KEY')]);

        // Assert response
        $response->assertStatus(422)
            ->assertJsonStructure(['error']);
    }

    /**
     * Test user logout with non-existent user.
     *
     * @return void
     */
    public function testUserLogoutWithNonExistentUser()
    {
        $response = $this->postJson('/api/auth/logout', [
            'email' => 'nonexisting@example.com'
        ], ['APP_KEY' => env('APP_KEY')]);

        // Assert response
        $response->assertNotFound();
    }
}
