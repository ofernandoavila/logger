<?php

namespace App\Http\Controllers;

use App\Annotations\ValidateRequest;
use App\Http\Response;
use App\Services\OrganizationService;
use App\Validations\OrganizationValidation;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $service
    )
    {
        
    }

    public function find(Request $request)
    {
        $result = '';

        if(!is_null($request->input('id'))) {
            $result = $this->service->get_organization_by_id(intval($request->input('id')));
        } else if(!is_null($request->input('search'))) {
            $result = $this->service->search($request->input('search'));
        }

        return Response::send_response('Organization created successfully.', $result, 201 );
    }

    #[ValidateRequest(OrganizationValidation::class, 'create')]
    public function create(Request $request)
    {
        $result = $this->service->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return Response::send_response('Organization created successfully.', $result, 201 );
    }
    
    #[ValidateRequest(OrganizationValidation::class, 'update')]
    public function update(Request $request)
    {
        $result = $this->service->update(intval($request->input('id')), [
            'name' => $request->input('name')
        ]);

        return Response::send_response('Organization updated successfully.', $result, 200 );
    }
    
    #[ValidateRequest(OrganizationValidation::class, 'delete', true)]
    public function delete(Request $request)
    {
        $result = $this->service->delete(intval($request->input('id')));

        return Response::send_response('Organization deleted successfully.', $result, 200 );
    }
    
    #[ValidateRequest(OrganizationValidation::class, 'add_user')]
    public function add_user(Request $request)
    {
        $result = $this->service->add_user_organization(intval($request->input('user_id')), intval($request->input('organization_id')), intval($request->input('role_id')));

        return Response::send_response('User added to organization successfully.', $result, 200 );
    }
    
    #[ValidateRequest(OrganizationValidation::class, 'remove_user')]
    public function remove_user(Request $request)
    {
        $result = $this->service->remove_user_organization(intval($request->input('user_id')), intval($request->input('organization_id')));

        return Response::send_response('User removed from organization successfully.', $result, 200 );
    }
    
    #[ValidateRequest(OrganizationValidation::class, 'alter_user_role')]
    public function alter_user_role(Request $request)
    {
        $result = $this->service->alter_user_role(
            intval($request->input('user_id')), 
            intval($request->input('organization_id')),
            intval($request->input('role_id'))
        );

        return Response::send_response('User role updated successfully.', $result, 200 );
    }
}
