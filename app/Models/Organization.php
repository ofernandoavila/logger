<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Organization extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'organization_role_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];    

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user')
                    ->withPivot('organization_role_id')
                    ->withTimestamps();
    }
}