<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\APIKey;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class APIKeyTest extends TestCase
{

    public function testValidAPIKey()
    {
        $middleware = new APIKey();

        $request = new Request();
        $request->headers->set('APP_KEY', env('APP_KEY'));

        $response = $middleware->handle($request, function ($request) {
            return new Response('Passed');
        });

        $this->assertEquals('Passed', $response->getContent());
    }

    public function testInvalidAPIKey()
    {
        $middleware = new APIKey();

        $request = new Request();
        $request->headers->set('APP_KEY', 'invalid_key');

        $response = $middleware->handle($request, function ($request) {
            return new Response('Passed');
        });

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('"Forbidden"', $response->getContent());
    }

    public function testMissingAPIKey()
    {
        $middleware = new APIKey();

        $request = new Request();

        $response = $middleware->handle($request, function ($request) {
            return new Response('Passed');
        });

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('"Forbidden"', $response->getContent());
    }
}
