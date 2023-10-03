<?php

namespace Tests\Feature\Http\Controllers\customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCustomerWithValidData()
    {
        $response = $this->postJson('/api/customer/create', [
            'name' => 'John Doe',
            'gender' => 'M',
            'email' => 'johndoe@example.com',
            'phone_number' => '1234567890',
            'date_of_birth' => '1990-01-01',
            'place_of_birth' => 'New York',
            'status' => 'M',
            'profession' => 'Engineer',
            'identification_type' => 'ID',
            'issue_date' => '2020-01-01',
            'issue_place' => 'New York',
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert response
        $response->assertStatus(201)
            ->assertJsonStructure(['success', 'customer']);

        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '1234567890'
        ]);
    }

    public function testCreateCustomerWithInvalidData()
    {
        $response = $this->postJson('/api/customer/create', [
            'name' => 'John Doe',
            'gender' => 'X',
            'email' => 'invalidemail',
            'phone_number' => '123',
            'date_of_birth' => 'invaliddate',
            'place_of_birth' => 123,
            'status' => 'X',
            'profession' => 123,
            'identification_type' => 'X',
            'issue_date' => 'invaliddate',
            'issue_place' => 123,
        ], [
            'APP_KEY' => env('APP_KEY'),
            'Authorization' => $this->generatedToken()
        ]);

        // Assert
        $response->assertStatus(400)
            ->assertJsonStructure([
                'gender', 'email', 'phone_number', 'date_of_birth', 'place_of_birth', 'status', 'profession',
                'identification_type', 'issue_date', 'issue_place'
            ]);
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
