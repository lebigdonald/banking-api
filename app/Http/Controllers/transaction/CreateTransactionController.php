<?php

namespace App\Http\Controllers\transaction;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateTransactionController
{
    /**
     * @LRDparam account_id_from required|numeric
     * @LRDparam account_id_to required|numeric
     * @LRDparam amount required|numeric
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function transaction(Request $request): JsonResponse
    {
        try {
            $validRules = 'required|numeric';
            $validator = Validator::make($request->all(), [
                'account_id_from' => $validRules,
                'account_id_to' => $validRules,
                'amount' => $validRules
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $balances = DB::select('CALL getAccountBalance(?)', [$request->account_id_from]);
            $balance = 0;
            if (!empty($balances)) {
                $balance = (int)$balances[0]->balance - (int)$request->amount;
            }

            if ($balance > 0) {
                DB::beginTransaction();

                DB::select('CALL createTransaction(?, ?, ?)', [
                    $request->account_id_from, $request->account_id_to, $request->amount
                ]);

                DB::commit();

                $user = json_decode($request->user);
                Log::info("The user $user->id performed a transaction of $request->amount from account $request->account_id_from to account $request->account_id_to");

                $status = 200;
                $response = ['success' => 'Transaction successfully performed'];
            } else {
                $status = 400;
                $response = ['error' => "Insufficient funds on account $request->account_id_from"];
            }

            return response()->json($response, $status);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            return response()->json([
                'error' => 'Transaction not performed ' . $exception->getMessage()
            ], 422);
        }
    }
}
