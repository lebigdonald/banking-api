<?php

namespace Tests\Unit\Http\Middleware;

use Illuminate\Http\Response;
use Tests\TestCase;

class CorsTest extends TestCase
{
    public function testHeaderWithValidHeaders()
    {
        // Arrange
        $response = new Response();

        // Act
        $response = $response->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');

        // Assert
        $this->assertTrue($response->headers->has('Access-Control-Allow-Origin'));
        $this->assertTrue($response->headers->has('Access-Control-Allow-Methods'));
        $this->assertTrue($response->headers->has('Access-Control-Allow-Headers'));
    }

    public function testHeaderWithInValidHeaders()
    {
        // Arrange
        $response = new Response();

        // Act
        $response = $response->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        // Assert
        $this->assertTrue($response->headers->has('Access-Control-Allow-Origin'));
        $this->assertTrue($response->headers->has('Access-Control-Allow-Methods'));
        $this->assertFalse($response->headers->has('Access-Control-Allow-Headers'));
    }
}
