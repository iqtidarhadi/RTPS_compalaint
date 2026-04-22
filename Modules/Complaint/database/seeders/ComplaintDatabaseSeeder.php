<?php

namespace Modules\Complaint\Database\Seeders;

use Illuminate\Database\Seeder;

class ComplaintDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ComplaintDepartmentsSeeder::class,
            ComplaintServicesSeeder::class,
            ComplaintRolesSeeder::class,
            ComplaintDepartmentUsersSeeder::class,
            ComplaintDemoDataSeeder::class,
        ]);
    }
}
