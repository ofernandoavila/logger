<?php

namespace App\Validations;

use App\Exceptions\RequestValidationFailedException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthValidation {
    public static function create_account(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException(
                            'Validation failed', [
                                'mesage' => 'Missing params...',
                                'data' => $validator->errors(),
                            ]);
        }

        return true;
    }
    
    public static function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException(
                            'Validation failed', [
                                'mesage' => 'Missing params...',
                                'data' => $validator->errors(),
                            ]);
        }

        return true;
    }
}