<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class ForceJsonResponseTest extends TestCase
{

    public function testHandleSetsAcceptHeaderToJson()
    {
        $middleware = new ForceJsonResponse();
        $request = new Request();

        $middleware->handle($request, function ($req) {
            $this->assertEquals('application/json', $req->headers->get('Accept'));
            return $req;
        });
    }

    public function testHandleDoesNotSetAcceptHeaderToJson()
    {
        $middleware = new ForceJsonResponse();
        $request = new Request();

        $middleware->handle($request, function ($req) {
            $this->assertNotEquals('text/html', $req->headers->get('Accept'));
            return $req;
        });
    }
}
