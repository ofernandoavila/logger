<?php

namespace App\Http\Controllers;

use App\Annotations\ValidateRequest;
use App\Http\Response;
use App\Models\Group;
use App\Services\ApplicationService;
use App\Services\OrganizationService;
use App\Validations\ApplicationValidation;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct(
        protected ApplicationService $service,
        protected OrganizationService $organizationService
    )
    {
        
    }

    public function find(Request $request)
    {
        $result = '';

        if(!is_null($request->input('id'))) {
            $result = $this->service->get_or_die(intval($request->input('id')));
        } else if(!is_null($request->input('search'))) {
            $result = $this->service->search($request->input('search'));
        }

        return Response::send_response('Search is done.', $result, 200 );
    }
    
    public function find_group(Request $request)
    {
        $result = '';

        if(!is_null($request->input('id'))) {
            $result = $this->service->get_group_or_die(intval($request->input('id')));
        } else if(!is_null($request->input('search'))) {
            $result = $this->service->search_group($request->input('search'));
        }

        return Response::send_response('Search is done.', $result, 200 );
    }

    #[ValidateRequest(ApplicationValidation::class, 'create')]
    public function create(Request $request)
    {
        $result = $this->service->create(
            $request->input('name'),
            $request->input('environment', ''),
            $this->organizationService->get_organization_by_id(intval($request->input('organization_id')))
        );

        return Response::send_response('Application created.', [ $result ], 201);
    }
    
    #[ValidateRequest(ApplicationValidation::class, 'create_group')]
    public function create_group(Request $request)
    {
        $group = $this->service->create_group($request->input('name'), $request->input('organization_id'));

        return Response::send_response('Application created.', [ $group ], 201);
    }

    #[ValidateRequest(ApplicationValidation::class, 'update')]
    public function update(Request $request)
    {
        $result = $this->service->update(
            $request->input('id'),
            $request->input('name'),
            $request->input('environment', ''),
        );

        return Response::send_response('Application updated.', [ $result ], 201);
    }
    
    #[ValidateRequest(ApplicationValidation::class, 'update_group')]
    public function update_group(Request $request)
    {
        $group = $this->service->update_group(
            $request->input('id'),
            $request->input('name'),
            $request->input('description', '')
        );

        return Response::send_response('Application updated.', [ $group ], 201);
    }

    #[ValidateRequest(ApplicationValidation::class, 'delete')]
    public function delete(Request $request)
    {
        $result = $this->service->delete(intval($request->input('id')));
        return Response::send_response('Application deleted.', [ $result ], 201);
    }
    
    #[ValidateRequest(ApplicationValidation::class, 'delete_group')]
    public function delete_group(Request $request)
    {
        $group = $this->service->delete_group(intval($request->input('id')));
        return Response::send_response('Group deleted.', [ $group ], 201);
    }
    
    #[ValidateRequest(ApplicationValidation::class, 'add_application_group')]
    public function add_application_group(Request $request)
    {
        $result = $this->service->add_application_to_group(intval($request->input('application_id')), intval($request->input('group_id')));
        return Response::send_response('Application add_application_groupd.', [ $result ], 201);
    }
    
    #[ValidateRequest(ApplicationValidation::class, 'remove_application_group')]
    public function remove_application_group(Request $request)
    {
        $result = $this->service->remove_application_from_group(intval($request->input('application_id')), intval($request->input('group_id')));
        return Response::send_response('Application removed from group.', [ $result ], 201);
    }
}
