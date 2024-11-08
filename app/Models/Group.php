<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'organization_id',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'organization_id'
    ];

    protected $with = [ 'organization', 'applications' ];

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'application_group');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
