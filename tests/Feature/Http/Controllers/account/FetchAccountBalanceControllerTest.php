<?php

namespace Tests\Feature\Http\Controllers\account;

use Tests\TestCase;

class FetchAccountBalanceControllerTest extends TestCase
{
    public function testBalanceWithValidAccountId()
    {
        $response = $this->getJson('/api/account/1/balance', [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertStatus(200)
            ->assertJsonStructure(['balance']);
    }

    public function testBalanceWithNonExistingAccountId()
    {
        $response = $this->getJson('/api/account/0/balance', [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertNotFound();
    }

    /**
     * @return mixed
     */
    private function generatedToken(): mixed
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ], ['APP_KEY' => env('APP_KEY')]);

        return $response->getOriginalContent()['token'];
    }
}
