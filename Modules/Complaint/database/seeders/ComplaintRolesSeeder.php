<?php

namespace Modules\Complaint\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ComplaintRolesSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'Citizen',
            'Service Point Officer',
            'Appellate Authority',
            'RTS Commission Officer',
            'Admin',
        ];

        foreach ($roles as $roleName) {
            Role::findOrCreate($roleName, 'web');
        }
    }
}
