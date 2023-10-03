<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
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
        if (!$request->hasHeader('Authorization')) {
            return response()->json('Unauthorized Access', 401);
        } else {
            $token = explode(' ', $request->header('Authorization'))[1];

            $users = DB::select('CALL getTokenizedUsers()');

            $connectedUser = null;
            if (!empty($users)) {
                foreach ($users as $user) {
                    if (Hash::check($token, $user->api_token)) {
                        $connectedUser = json_encode($user);
                    }
                }
            }

            if ($connectedUser) {
                $request['user'] = $connectedUser;

                return $next($request);
            } else {
                return response()->json('Unauthorized Access', 401);
            }
        }
    }
}
