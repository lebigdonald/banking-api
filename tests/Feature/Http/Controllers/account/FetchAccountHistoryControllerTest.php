<?php

namespace Tests\Feature\Http\Controllers\account;

use Tests\TestCase;

class FetchAccountHistoryControllerTest extends TestCase
{
    public function testHistoryWithValidAccountId()
    {
        $response = $this->getJson('/api/account/1/history', [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertStatus(200)
            ->assertJsonStructure(['transactions']);
    }

    public function testHistoryWithNonExistingAccountId()
    {
        $response = $this->getJson('/api/account/0/history', [
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
