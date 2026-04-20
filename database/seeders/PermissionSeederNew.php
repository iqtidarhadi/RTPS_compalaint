<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Define all permissions for location management modules
        $permissions = [
            // officer permissions
            'officer-list',
            'officer-create',
            'officer-edit', 
            'officer-delete',
            
            // department permissions (already exist but adding for completeness)
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',
            
            // citizen permissions (already exist but adding for completeness)
            'citizen-list',
            'citizen-create',
            'citizen-edit',
            'citizen-delete',
            
         
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to Developer role
        $developerRole = Role::where('name', 'Developer')->first();
        if ($developerRole) {
            $developerRole->syncPermissions(Permission::all());
        }

        $this->command->info('Location management permissions created successfully!');
    }
}
