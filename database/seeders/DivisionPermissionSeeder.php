<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Backend\Menu;

class DivisionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create division menu
        $menu = Menu::firstOrCreate([
            'title' => 'division',
            'status' => 1,
        ]);

        // Define division permissions
        $divisionPermissions = [
            'division-list',
            'division-create',
            'division-edit',
            'division-delete',
        ];

        // Create division permissions
        foreach ($divisionPermissions as $permissionName) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
                'menu_id' => $menu->id,
            ]);
            
            $this->command->info("Permission '{$permissionName}' created/found successfully!");
        }

        // Assign division permissions to Developer role
        $developerRole = Role::where('name', 'Developer')->first();
        if ($developerRole) {
            $divisionPermissionObjects = Permission::whereIn('name', $divisionPermissions)->get();
            $developerRole->givePermissionTo($divisionPermissionObjects);
            $this->command->info('Division permissions assigned to Developer role!');
        }

        $this->command->info('Division permissions setup completed successfully!');
    }
}
