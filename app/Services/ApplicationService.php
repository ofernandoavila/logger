<?php

namespace App\Services;

use App\Exceptions\Exception;
use App\Models\Application;
use App\Models\Group;
use App\Models\Organization;

class ApplicationService extends Service {
    public function __construct(
        protected OrganizationService $organizationService
    )
    {
        
    }

    public function search(string $search)
    {
        return Application::where('name', 'like', "%$search%")
                            ->orWhere('environment', 'like', "%$search%")
                            ->orWhereHas('organization', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
                            })
                            ->get();
    }
    
    public function search_group(string $search)
    {
        return Group::where('name', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhereHas('organization', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
                            })
                            ->get();
    }

    public function create(string $name, string $environment = "", Organization $organization)
    {
        $data = [];
        $data['name'] = $name;
        $data['organization_id'] = $organization->id;

        if($environment != '') {
            $data['environment'] = $environment;
        }

        $application = Application::create($data);
        
        return $application->save();
    }
    
    public function update(int $id, string $name = '', string $environment = '')
    {
        $application = $this->get_or_die($id);

        if($name != '') {
            $application->name = $name;
        }

        if($environment != '') {
            $application->environment = $environment;
        }
        
        return $application->save();
    }
    
    public function delete(int $id)
    {
        return $this->get_or_die($id)->delete();
    }

    public function get_or_die(int $id)
    {
        $application = Application::find($id);

        if(is_null($application)) throw new Exception('Application not found', 404, [ 'Application was not found with given id' ]);

        return $application;
    }

    // Group

    public function create_group(string $name, int $organization_id, string $description = '')
    {
        $organization = $this->organizationService->get_organization_by_id($organization_id);
        
        if(is_null( $organization )) {
            throw new Exception('Organization not found', 404, [ 'Organization was not found with given id' ]);
        }

        $data = [];
        $data['name'] = $name;
        $data['organization_id'] = $organization->id;

        if($description != '') {
            $data['description'] = $description;
        }

        $group = Group::create($data);
        
        return $group->save();
    }
    
    public function update_group(int $id, string $name = '', string $description = '')
    {
        $group = $this->get_group_or_die($id);

        if($name != '') {
            $group->name = $name;
        }

        if($description != '') {
            $group->description = $description;
        }
        
        return $group->save();
    }
    
    public function delete_group(int $id)
    {
        $group = $this->get_group_or_die($id);

        foreach($group->applications()->getResults() as $application) {
            $group->applications()->detach($application->id);
        }

        return $group->delete();
    }

    public function add_application_to_group(int $application_id, int $group_id)
    {
        $group = $this->get_group_or_die($group_id);
        $group->applications()->attach($application_id);
        
        return $group->save();
    }

    public function remove_application_from_group(int $application_id, int $group_id)
    {
        $group = $this->get_group_or_die($group_id);
        $group->applications()->detach($application_id);
        
        return $group->save();
    }

    public function get_group_or_die(int $id)
    {
        $group = Group::find($id);

        if(is_null($group)) throw new Exception('Group not found', 404, [ 'Group was not found with given id' ]);

        return $group;
    }
}