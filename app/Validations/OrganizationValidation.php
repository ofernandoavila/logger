<?php

namespace App\Validations;

use App\Exceptions\Exception;
use App\Exceptions\RequestValidationFailedException;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationValidation {
    public function __construct(
        protected OrganizationService $service
    )
    {
        
    }
    public static function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
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
            'id' => 'required|integer|max:255',
            'name' => 'required|string|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function delete(Request $request)
    {
        $service = new OrganizationService();

        $id = $request->input('id');

        if(!is_null($id)) {
            if(!$service->get_organization_by_id(intval($id))) {
                throw new Exception(
                    'Organization was not found', 404, [ 'The organization was not found with de given parameter.' ]);
            }
        }

        if(is_null($id)) {
            throw new RequestValidationFailedException([ "id" => "Missing parameter 'id'" ]);
        }

        return true;
    }
    
    public static function add_user(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|max:255',
            'organization_id' => 'required|integer|max:255',
            'role_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function remove_user(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|max:255',
            'organization_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
    
    public static function alter_user_role(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|max:255',
            'organization_id' => 'required|integer|max:255',
            'role_id' => 'required|integer|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            throw new RequestValidationFailedException($validator->errors());
        }

        return true;
    }
}