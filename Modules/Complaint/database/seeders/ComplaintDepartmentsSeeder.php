<?php

namespace Modules\Complaint\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Complaint\Models\Department;

class ComplaintDepartmentsSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Police Department', 'status' => 'active'],
            ['name' => 'Health Department', 'status' => 'active'],
            ['name' => 'Municipal Department', 'status' => 'active'],
            ['name' => 'Fire Brigade', 'status' => 'active'],
            ['name' => 'Education Department', 'status' => 'active'],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['name' => $department['name']],
                ['status' => $department['status']]
            );
        }
    }
}
