<?php

namespace Tests\Feature\Http\Controllers\account;

use Tests\TestCase;

class CreateAccountControllerTest extends TestCase
{
    public function testCustomerAccountSuccess(): void
    {
        $response = $this->postJson('/api/account/create', [
            'account_number' => 123456789,
            'customer_id' => 1,
            'initial_amount' => 100000.00
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assertions
        $response->assertStatus(201)
            ->assertJsonStructure(['success', 'account']);;
    }

    public function testCustomerAccountFailure(): void
    {
        $response = $this->postJson('/api/account/create', [
            'account_number' => 123456789,
            'customer_id' => 1,
            'initial_amount' => 100000.00
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assertions
        $response->assertStatus(422)
            ->assertJsonStructure(['error']);
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
