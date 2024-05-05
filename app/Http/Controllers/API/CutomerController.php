<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CutomerController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstName" => ["required", "min:3", "max:15", "regex:/^[A-Za-z]+$/i"],
            "lastName" => ["required", "min:3", "max:15", "regex:/^[A-Za-z]+$/i"],
            "email" => ["required", "regex:/^(?!\.)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"],
            "country" => "required",
            "phoneNumber" => ["required", "min:3", "max:15", "regex:/^01\d{9,11}$/"],
            "policy" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'validate_err' => $validator->errors(),
            ]);
        } else {
            $customer = new Customer();
            $customer->firstName = $request->input("firstName");
            $customer->lastName = $request->input("lastName");
            $customer->email = $request->input("email");
            $customer->country = $request->input("country");
            $customer->phoneNumber = $request->input("phoneNumber");
            $customer->policy = $request->input("policy");
            $customer->save();

            return response()->json([
                'status' => 200,
                'message' => 'Form sent successfully',
            ]);
        }
    }
}
