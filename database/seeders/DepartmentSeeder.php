<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Department;

class DepartmentSeeder extends Seeder
{

    public function run(): void
    {

        $departments = [

            ['name' => 'Police Department'],
            ['name' => 'Health Department'],
            ['name' => 'Municipal Department'],
            ['name' => 'Fire Brigade'],
            ['name' => 'Education Department']

        ];


        foreach ($departments as $department) {

            Department::create([

                'name' => $department['name'],
                'status' => 'active'

            ]);

        }
          $this->command->info('Department created successfully!');
    }

}