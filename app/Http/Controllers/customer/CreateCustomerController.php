<?php

namespace App\Http\Controllers\customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateCustomerController
{
    /**
     * @LRDparam name required|string|min:2|max:100
     * @LRDparam gender string|M,F,O
     * @LRDparam email required|string|email|max:100
     * @LRDparam phone_number required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20
     * @LRDparam date_of_birth date
     * @LRDparam place_of_birth string
     * @LRDparam status string|M,S,D,W,O
     * @LRDparam profession string
     * @LRDparam identification_type string|ID,P
     * @LRDparam issue_date date
     * @LRDparam issue_place string
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'gender' => 'string|in:M,F,O',
                'email' => 'required|string|email|max:100|unique:customers',
                'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20|unique:customers',
                'date_of_birth' => 'date',
                'place_of_birth' => 'string',
                'status' => 'string|in:M,S,D,W,O',
                'profession' => 'string',
                'identification_type' => 'string|in:ID,P',
                'issue_date' => 'date',
                'issue_place' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $customer = DB::select('CALL createCustomer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->name, $request->gender, $request->email, $request->phone_number, $request->date_of_birth,
                $request->place_of_birth, $request->status, $request->profession, $request->identification_type,
                $request->issue_date, $request->issue_place
            ])[0];

            $user = json_decode($request->user);
            Log::info("The user {$user->id} have created a new customer $customer->id successfully");

            return response()->json([
                'success' => 'Customer successfully registered',
                'customer' => $customer
            ], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'error' => 'Customer not registered ' . $exception->getMessage()
            ], 422);
        }
    }
}
