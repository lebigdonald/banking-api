<?php

namespace App\Http\Controllers\account;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchAccountBalanceController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function balance(Request $request): JsonResponse
    {
        try {
            $balances = DB::select('CALL getAccountBalance(?)', [$request->account_id]);
            if (!empty($balances)) {
                $user = json_decode($request->user);
                Log::info("The user $user->id fetch account $request->account_id balance which is {$balances[0]->balance}");

                $status = 200;
                $response = $balances[0];
            } else {
                $status = 404;
                $response = ['error' => "Account doesn't exist"];
            }

            return response()->json($response, $status);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'error' => 'Transaction not performed ' . $exception->getMessage()
            ], 422);
        }
    }
}
