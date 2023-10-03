<?php

namespace App\Http\Controllers\security;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * @LRDparam email required|string|email|max:100
     * @LRDparam password required|string|min:6
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $users = DB::select('CALL getUserByEmail(?)', [$request->email]);

            if (!empty($users)) {
                $user = $users[0];

                if (Hash::check($request->password, $user->password)) {
                    $token = Str::random(80);

                    DB::select('CALL updateAPIToken(?, ?)', [$user->email, Hash::make($token)]);

                    Log::info("The user $user->id logged-in with token $token");

                    $status = 200;
                    $response = ['token' => "Bearer $token"];
                } else {
                    $status = 404;
                    $response = ['error' => 'Password mismatch'];
                }
            } else {
                $status = 404;
                $response = ['error' => 'User does not exist'];
            }

            return response()->json($response, $status);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'error' => 'User not logged-in ' . $exception->getMessage()
            ], 422);
        }
    }

}
