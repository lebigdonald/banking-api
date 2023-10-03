<?php

namespace Tests\Feature\Http\Controllers\transaction;

use Tests\TestCase;

class CreateTransactionControllerTest extends TestCase
{
    public function testTransactionWithValidData(): void
    {
        $response = $this->postJson('/api/transaction', [
            'account_id_from' => 1,
            'account_id_to' => 2,
            'amount' => 100
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertStatus(200)
            ->assertJsonStructure(['success']);
    }

    public function testTransactionWithInvalidData(): void
    {
        $response = $this->postJson('/api/transaction', [
            'account_id_from' => 'abc',
            'account_id_to' => 'xyz',
            'amount' => 'invalid'
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertStatus(400)
            ->assertJsonStructure(['account_id_from', 'account_id_to', 'amount']);
    }

    public function testTransactionWithInsufficientFunds(): void
    {
        $response = $this->postJson('/api/transaction', [
            'account_id_from' => 1,
            'account_id_to' => 2,
            'amount' => 1000000000
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertStatus(400)
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
