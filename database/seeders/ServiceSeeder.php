<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;
use App\Models\Backend\Department;
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
         $police = Department::where('name', 'Police Department')->firstOrFail();
        $health = Department::where('name', 'Health Department')->firstOrFail();
        Service::create([
            'dept_id' => $police->id, // replace with real department id
            'service_name' => 'CNIC Verification',
            'sla_days' => 3,
            'description' => 'Verify CNIC details within system',
            'is_active' => true,
        ]);

        Service::create([
            'dept_id' => $police->id,
            'service_name' => 'Police Clearance',
            'sla_days' => 7,
            'description' => 'Issue police clearance certificate',
            'is_active' => true,
        ]);
           Service::create([
            'dept_id' => $health->id,
            'service_name' => 'Medical Certificate',
            'sla_days' => 2,
            'description' => 'Issue medical fitness certificate',
            'is_active' => true,
        ]);
         $this->command->info('Services created successfully!');
    }
}
