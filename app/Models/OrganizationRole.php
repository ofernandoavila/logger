<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrganizationRole extends Model {
    use HasFactory, Notifiable;
    
    protected $table_name = 'organization_roles';

    protected $fillable = [
        'role',
        'level',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}