<?php

namespace App\Http\Controllers\security;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegistrationController
{
    /**
     * @LRDparam name required|string|min:2|max:100
     * @LRDparam email required|string|email|max:100
     * @LRDparam password required|string|min:6
     * @LRDparam password_confirmation required|string|min:6
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registration(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'password_confirmation' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $users = DB::select('CALL getUserByEmail(?)', [$request->email]);

            if (empty($users)) {
                $user = DB::select('CALL createUser(?, ?, ?)', [
                    $request->name, $request->email, bcrypt($request->password)
                ])[0];

                Log::info("The user $user->id was created successfully");

                $status = 201;
                $responses = [
                    'success' => 'User successfully registered',
                    'user' => $user
                ];
            } else {
                $status = 422;
                $responses = ['error' => 'User already exist'];
            }

            return response()->json($responses, $status);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'error' => 'User not registered ' . $exception->getMessage()
            ], 422);
        }
    }
}
