<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    public function testHandleWithValidToken()
    {
        // Arrange
        $token = 'valid_token';
        $user = (object) [
            'api_token' => Hash::make($token)
        ];
        $request = new Request();
        $request->headers->set('Authorization', "Bearer $token");
        DB::shouldReceive('select')->once()->andReturn([$user]);

        // Act
        $response = $this->app->make(Authenticate::class)->handle($request, function ($req) {
            return response()->json('Success', 200);
        });

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(json_encode($user), $request['user']);
    }

    public function testHandleWithInvalidToken()
    {
        // Arrange
        $token = 'invalid_token';
        $request = new Request();
        $request->headers->set('Authorization', "Bearer $token");
        DB::shouldReceive('select')->once()->andReturn([]);

        // Act
        $response = $this->app->make(Authenticate::class)->handle($request, function ($req) {
            return response()->json('Success', 200);
        });

        // Assert
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertNull($request['user']);
    }

    public function testHandleWithoutAuthorizationHeader()
    {
        // Arrange
        $request = new Request();

        // Act
        $response = $this->app->make(Authenticate::class)->handle($request, function ($req) {
            return response()->json('Success', 200);
        });

        // Assert
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertNull($request['user']);
    }
}
