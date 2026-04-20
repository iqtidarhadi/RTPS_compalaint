<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Backend\Menu;

class FixLocationPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:fix-location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix all location module permissions and menus';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing location permissions and menus...');

        // Define all location modules with their permissions
        $locationModules = [
            'province' => [
                'province-list',
                'province-create',
                'province-edit',
                'province-delete',
            ],
            'district' => [
                'district-list',
                'district-create',
                'district-edit',
                'district-delete',
            ],
            'division' => [
                'division-list',
                'division-create',
                'division-edit',
                'division-delete',
            ],
            'tehsil' => [
                'tehsil-list',
                'tehsil-create',
                'tehsil-edit',
                'tehsil-delete',
            ],
            'union_council' => [
                'union-council-list',
                'union-council-create',
                'union-council-edit',
                'union-council-delete',
            ],
            'village' => [
                'village-list',
                'village-create',
                'village-edit',
                'village-delete',
            ],
        ];

        $this->info('Current menus in database:');
        $allMenus = Menu::all();
        foreach ($allMenus as $menu) {
            $this->line("ID: {$menu->id} - Title: {$menu->title} - Status: " . ($menu->status ? 'Active' : 'Inactive'));
        }

        $createdMenus = 0;
        $createdPermissions = 0;
        $existingMenus = 0;
        $existingPermissions = 0;

        // Create/Update menus and permissions
        foreach ($locationModules as $menuTitle => $permissions) {
            // Create or find menu
            $menu = Menu::where('title', $menuTitle)->first();
            if (!$menu) {
                $menu = Menu::create([
                    'title' => $menuTitle,
                    'status' => 1,
                ]);
                $this->info("✓ Created menu: {$menuTitle}");
                $createdMenus++;
            } else {
                $this->warn("✗ Menu already exists: {$menuTitle} (ID: {$menu->id})");
                $existingMenus++;
                // Ensure status is active
                if (!$menu->status) {
                    $menu->update(['status' => 1]);
                    $this->info("✓ Activated menu: {$menuTitle}");
                }
            }

            // Create permissions for this menu
            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->where('guard_name', 'web')->first();
                
                if (!$permission) {
                    Permission::create([
                        'name' => $permissionName,
                        'guard_name' => 'web',
                        'menu_id' => $menu->id,
                    ]);
                    $this->info("✓ Created permission: {$permissionName}");
                    $createdPermissions++;
                } else {
                    $this->warn("✗ Permission already exists: {$permissionName}");
                    $existingPermissions++;
                    // Update menu_id if needed
                    if ($permission->menu_id != $menu->id) {
                        $permission->update(['menu_id' => $menu->id]);
                        $this->info("✓ Fixed menu_id for permission: {$permissionName}");
                    }
                }
            }
        }

        // Assign all permissions to Developer role
        $developerRole = Role::where('name', 'Developer')->first();
        if ($developerRole) {
            $allPermissions = Permission::all();
            $developerRole->syncPermissions($allPermissions);
            $this->info('✓ All permissions assigned to Developer role!');
        } else {
            $this->error('✗ Developer role not found!');
        }

        $this->info('=== SUMMARY ===');
        $this->info("Menus - Created: {$createdMenus}, Existing: {$existingMenus}");
        $this->info("Permissions - Created: {$createdPermissions}, Existing: {$existingPermissions}");
        $this->info('Location permissions and menus fixed successfully!');
    }
}
