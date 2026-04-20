<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Backend\Menu;

class CreateDivisionPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:create-division';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create division permissions and assign to Developer role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating division permissions...');

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

        $createdCount = 0;
        $existingCount = 0;

        // Create division permissions
        foreach ($divisionPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->where('guard_name', 'web')->first();
            
            if (!$permission) {
                Permission::create([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                    'menu_id' => $menu->id,
                ]);
                $this->info("✓ Created permission: {$permissionName}");
                $createdCount++;
            } else {
                $this->warn("✗ Permission already exists: {$permissionName}");
                $existingCount++;
            }
        }

        // Assign division permissions to Developer role
        $developerRole = Role::where('name', 'Developer')->first();
        if ($developerRole) {
            $divisionPermissionObjects = Permission::whereIn('name', $divisionPermissions)->get();
            $developerRole->givePermissionTo($divisionPermissionObjects);
            $this->info('✓ Division permissions assigned to Developer role!');
        } else {
            $this->error('✗ Developer role not found!');
        }

        $this->info("Summary: {$createdCount} created, {$existingCount} already existed");
        $this->info('Division permissions setup completed successfully!');
    }
}
