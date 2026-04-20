<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Officer;
use App\Models\Backend\Department;
use Illuminate\Support\Str;

class OfficerSeeder extends Seeder
{
    public function run(): void
    {

     $police = Department::where('name', 'Police Department')->firstOrFail();
        $health = Department::where('name', 'Health Department')->firstOrFail();
        Officer::create([
            'dept_id' => $police->id, // replace with real department id
            'name' => 'Ali Khan',
            'designation' => 'SP',
            'email' => 'ali@example.com',
            'phone' => '03001234567',
            'is_active' => true,
        ]);

        Officer::create([
            'dept_id' => $health->id,
            'name' => 'Sara Ahmed',
            'designation' => 'MO',
            'email' => 'sara@example.com',
            'phone' => '03111234567',
            'is_active' => true,
        ]);
         $this->command->info('OFFicer  created successfully!');
    }
}
