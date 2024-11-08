<?php

namespace App\Validations;

use App\Exceptions\Exception;
use App\Exceptions\RequestValidationFailedException;
use App\Services\ApplicationService;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationValidation {
    public function __construct(
        protected ApplicationService $service
    )
    {
        
    }
    public static function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'organization_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function create_group(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'organization_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function update(Request $request)
    {
        $rules = [
            'id' => 'required|integer|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function update_group(Request $request)
    {
        $rules = [
            'id' => 'required|integer|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function delete(Request $request)
    {
        if(is_null($request->input('id'))) {
            throw new RequestValidationFailedException([ "id" => "Missing parameter 'id'" ]);
        }
                
        return true;
    }
    
    public static function delete_group(Request $request)
    {        
        if(is_null($request->input('id'))) {
            throw new RequestValidationFailedException([ "id" => "Missing parameter 'id'" ]);
        }
        
        return true;
    }
    
    public static function add_application_to_group(Request $request)
    {
        $rules = [
            'application_id' => 'required|integer|max:255',
            'group_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function remove_application_from_group(Request $request)
    {
        $rules = [
            'application_id' => 'required|integer|max:255',
            'group_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
}