<?php

namespace App\Http\Controllers\account;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchAccountHistoryController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function history(Request $request): JsonResponse
    {
        try {
            $histories = DB::select('CALL getAccountHistory(?)', [$request->account_id]);
            if (!empty($histories)) {
                $user = json_decode($request->user);
                Log::info("The user $user->id fetched account $request->account_id history");

                $status = 200;
                $response = ['transactions' => $histories];
            } else {
                $status = 404;
                $response = ['error' => "No transaction performed by account $request->account_id"];
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
