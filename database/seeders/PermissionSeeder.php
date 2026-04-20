<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Backend\Menu;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Define menus and their permissions
        $menuPermissions = [
            'officer' => [
                'officer-list',
                'officer-create',
                'officer-edit',
                'officer-delete',
            ],
            'citizen' => [
                'citizen-list',
                'citizen-create',
                'citizen-edit',
                'citizen-delete',
            ],
            'department' => [
                'department-list',
                'department-create',
                'department-edit',
                'department-delete',
            ],
            'service' => [
                'service-list',
                'service-create',
                'service-edit',
                'service-delete',
            ],
          
        ];

        // Create menus and permissions
        foreach ($menuPermissions as $menuTitle => $permissions) {
            // Create or find menu
            $menu = Menu::firstOrCreate([
                'title' => $menuTitle,
                'status' => 1,
            ]);

            // Create permissions for this menu
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                    'menu_id' => $menu->id,
                ]);
            }
        }

        // Assign all permissions to Developer role
        $developerRole = Role::where('name', 'Developer')->first();
        if ($developerRole) {
            $developerRole->syncPermissions(Permission::all());
        }

        $this->command->info('Location management menus and permissions created successfully!');
    }
}
