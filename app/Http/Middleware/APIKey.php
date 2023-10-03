<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIKey
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->hasHeader('APP_KEY') || ($request->header('APP_KEY') !== env('APP_KEY'))
            || is_null($request->header('APP_KEY')) || is_null(env('APP_KEY'))) {
            return response()->json('Forbidden', 403);
        }

        return $next($request);
    }
}
