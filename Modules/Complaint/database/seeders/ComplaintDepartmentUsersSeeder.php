<?php

namespace Modules\Complaint\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\Complaint\Models\Department;
use Spatie\Permission\Models\Role;

class ComplaintDepartmentUsersSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::query()->get();

        if ($departments->isEmpty()) {
            return;
        }

        $hasDepartmentIdColumn = Schema::hasColumn('users', 'department_id');
        $hasUserTypeColumn = Schema::hasColumn('users', 'user_type');

        foreach ($departments as $department) {
            $users = [
                [
                    'role' => 'Service Point Officer',
                    'firstname' => 'Service Point',
                    'lastname' => $department->name,
                    'email' => $this->makeEmail($department->name, 'spo'),
                ],
                [
                    'role' => 'Appellate Authority',
                    'firstname' => 'Appellate',
                    'lastname' => $department->name,
                    'email' => $this->makeEmail($department->name, 'appellate'),
                ],
            ];

            foreach ($users as $userData) {
                $user = User::firstOrNew(['email' => $userData['email']]);

                $payload = [
                    'firstname' => $userData['firstname'],
                    'lastname' => $userData['lastname'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ];

                if ($hasUserTypeColumn) {
                    $payload['user_type'] = 'department_user';
                }

                if ($hasDepartmentIdColumn) {
                    $payload['department_id'] = $department->id;
                }

                $user->forceFill($payload)->save();
                $user->syncRoles([Role::findOrCreate($userData['role'], 'web')]);
            }
        }

        $admin = User::firstOrNew(['email' => 'complaint.admin@example.com']);
        $adminPayload = [
            'firstname' => 'Complaint',
            'lastname' => 'Admin',
            'email' => 'complaint.admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ];
        if ($hasUserTypeColumn) {
            $adminPayload['user_type'] = 'admin';
        }
        $admin->forceFill($adminPayload)->save();
        $admin->syncRoles([Role::findOrCreate('Admin', 'web')]);

        $rtsOfficer = User::firstOrNew(['email' => 'rts.commission@example.com']);
        $rtsPayload = [
            'firstname' => 'RTS',
            'lastname' => 'Commission',
            'email' => 'rts.commission@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ];
        if ($hasUserTypeColumn) {
            $rtsPayload['user_type'] = 'department_user';
        }
        $rtsOfficer->forceFill($rtsPayload)->save();
        $rtsOfficer->syncRoles([Role::findOrCreate('RTS Commission Officer', 'web')]);
    }

    private function makeEmail(string $departmentName, string $prefix): string
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '.', $departmentName));
        $slug = trim($slug, '.');

        return "{$prefix}.{$slug}@example.com";
    }
}
