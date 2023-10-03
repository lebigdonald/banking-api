<?php

namespace App\Http\Controllers\account;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateAccountController
{
    /**
     * @LRDparam account_number required|numeric
     * @LRDparam customer_id required|numeric
     * @LRDparam initial_amount required|numeric
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $validRules = 'required|numeric';
            $validator = Validator::make($request->all(), [
                'account_number' => $validRules,
                'customer_id' => $validRules,
                'initial_amount' => $validRules
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $accountExist = DB::select('CALL verifyAccount(?, ?)', [
                    $request->account_number, $request->customer_id]
            );

            if (empty($accountExist)) {
                DB::beginTransaction();

                $account = DB::select('CALL createAccount(?, ?, ?)', [
                    $request->account_number, $request->customer_id, $request->initial_amount
                ])[0];

                DB::select('CALL initialDeposit(?, ?)', [$account->id, $request->initial_amount]);

                DB::commit();

                $user = json_decode($request->user);
                Log::info("The user $user->id have created a new account $account->id with initial amount $request->initial_amount for customer with ID $request->customer_id successfully");

                $status = 201;
                $response = [
                    'success' => 'Account successfully created',
                    'account' => $account
                ];
            } else {
                $status = 422;
                $response = ['error' => 'Account number already exist for this customer'];
            }

            return response()->json($response, $status);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());

            return response()->json([
                'error' => 'Account not created ' . $exception->getMessage()
            ], 422);
        }
    }
}
