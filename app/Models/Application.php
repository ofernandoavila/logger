<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'name',
        'environment',
        'organization_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'organization_id',
        'pivot'
    ];

    protected $with = ['organization'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
