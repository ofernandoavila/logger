<?php

namespace App\Services;

use App\Exceptions\Exception;
use App\Models\Organization;
use App\Models\User;

class OrganizationService extends Service {
    public function create(array $data)
    {
        $user = $this->get_logged_user();
        
        $organization = $this->get_organization_by_name($data['name']);
        if($organization) throw new Exception('Invalid organization name', 400, [ 'The given name is already in use' ]);
        
        $organization = $this->get_organization_by_email($data['email']);
        if($organization) throw new Exception('Invalid organization email', 400, [ 'The given email is already in use' ]);

        $organization = Organization::create($data);
        $organization->users()->attach($user->id, [ 'organization_role_id' => 1 ]);

        return $organization->save();
    }

    public function search(string $search)
    {
        return Organization::where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%")
                            ->get();
    }

    public function get_organization_by_id(int $organization_id)
    {
        return Organization::find($organization_id);
    }

    public function get_organization_by_name(string $name)
    {
        return Organization::where('name', $name)->first();
    }
    
    public function get_organization_by_email(string $email)
    {
        return Organization::where('email', $email)->first();
    }
    
    public function update(int $organization_id, array $data)
    {
        $organization = Organization::find($organization_id);

        if(isset($data['name'])) {
            $organization->name = $data['name'];
        }

        $organization->save();

        return $organization;
    }
    
    public function delete(int $organization_id)
    {
        $organization = Organization::find($organization_id);

        foreach($organization->users()->getResults() as $user) {
            $organization->users()->detach($user->id);
        }

        return $organization->delete();
    }
    
    public function add_user_organization(int $user_id, int $organization_id, int $role_id)
    {
        $user = User::find($user_id);
        $organization = Organization::find($organization_id);

        if(!$user) throw new Exception('The user was not found', 404, [ 'The user was not found with the given id:' . $user_id ]);

        if(!$organization) throw new Exception('The organization was not found', 404, [ 'The organization was not found with the given id:' . $organization_id ]);
        
        $organization->users()->attach($user->id, [ 'organization_role_id' => $role_id ]);

        return $organization;
    }
    
    public function remove_user_organization(int $user_id, int $organization_id)
    {
        $user = User::find($user_id);
        $organization = Organization::find($organization_id);

        if(!$user) throw new Exception('The user was not found', 404, [ 'The user was not found with the given id:' . $user_id ]);

        if(!$organization) throw new Exception('The organization was not found', 404, [ 'The organization was not found with the given id:' . $organization_id ]);
        
        $organization->users()->detach($user->id);

        return $organization;
    }
    
    public function alter_user_role(int $user_id, int $organization_id, int $role_id)
    {
        $organization = $this->get_organization_by_id($organization_id);
        if(!$organization) throw new Exception('The organization was not found', 404, [ 'The organization was not found with the given id:' . $organization_id ]);
        
        $user = $organization->users()->where('user_id', $user_id);
        if(!$user) throw new Exception('The user was not found', 404, [ 'The user was not found in the organization. id: ' . $user_id ]);

        $organization->users()->updateExistingPivot($user_id, ['organization_role_id' => $role_id]);

        return $organization->save();
    }
}