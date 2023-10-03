<?php

namespace App\Http\Controllers\security;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LogOutController extends Controller
{
    /**
     * @LRDparam email required|string|email|max:100
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $users = DB::select('CALL getUserByEmail(?)', [$request->email]);
            if (!empty($users)) {
                $user = $users[0];

                if ($user->api_token) {
                    DB::select('CALL updateAPIToken(?, ?)', [$user->email, null]);

                    Log::info("The user $user->id has logged-out");

                    $status = 200;
                    $response = ['success' => 'You have been successfully logged out'];
                } else {
                    $status = 422;
                    $response = ['error' => 'User not logged-in'];
                }
            } else {
                $status = 404;
                $response = ['error' => 'User does not exist'];
            }

            return response()->json($response, $status);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'error' => 'User not logged-out ' . $exception->getMessage()
            ], 422);
        }
    }

}
