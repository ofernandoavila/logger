<?php

namespace Database\Seeders;

use App\Models\OrganizationRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrganizationRole::create([
            'role' => 'Administrator/Owner',
            'level' => 0
        ]);

        OrganizationRole::create([
            'role' => 'Director',
            'level' => 1
        ]);
        
        OrganizationRole::create([
            'role' => 'Manager',
            'level' => 2
        ]);
        
        OrganizationRole::create([
            'role' => 'Devops',
            'level' => 3
        ]);
        
        OrganizationRole::create([
            'role' => 'Developer',
            'level' => 3
        ]);
        
        OrganizationRole::create([
            'role' => 'QA',
            'level' => 4
        ]);
        
        OrganizationRole::create([
            'role' => 'UX/UI',
            'level' => 4
        ]);
    }
}
