<?php

namespace Modules\Complaint\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Complaint\Models\Department;
use Modules\Complaint\Models\Service;

class ComplaintServicesSeeder extends Seeder
{
    public function run(): void
    {
        $hasDepartmentIdColumn = Schema::hasColumn('services', 'department_id');

        $serviceMap = [
            'Police Department' => [
                ['service_name' => 'FIR Registration', 'sla_days' => 2, 'description' => 'Register and process citizen FIR complaints.'],
                ['service_name' => 'Police Clearance Certificate', 'sla_days' => 7, 'description' => 'Issue police clearance certificates.'],
            ],
            'Health Department' => [
                ['service_name' => 'Medical Certificate', 'sla_days' => 3, 'description' => 'Issue medical fitness and verification certificates.'],
                ['service_name' => 'Hospital Service Complaint', 'sla_days' => 5, 'description' => 'Resolve complaints against health facilities and staff.'],
            ],
            'Municipal Department' => [
                ['service_name' => 'Birth Certificate', 'sla_days' => 5, 'description' => 'Process birth certificate issuance requests.'],
                ['service_name' => 'Property Transfer', 'sla_days' => 10, 'description' => 'Handle property transfer and mutation service requests.'],
            ],
            'Fire Brigade' => [
                ['service_name' => 'Fire Safety Certificate', 'sla_days' => 4, 'description' => 'Issue fire safety compliance certificates.'],
                ['service_name' => 'Emergency Response Complaint', 'sla_days' => 1, 'description' => 'Track fire brigade response and emergency complaints.'],
            ],
            'Education Department' => [
                ['service_name' => 'School Leaving Certificate', 'sla_days' => 4, 'description' => 'Issue school leaving and verification certificates.'],
                ['service_name' => 'Scholarship Complaint', 'sla_days' => 6, 'description' => 'Resolve scholarship and admission-related complaints.'],
            ],
        ];

        foreach ($serviceMap as $departmentName => $services) {
            $department = Department::query()->where('name', $departmentName)->first();

            if (!$department) {
                continue;
            }

            foreach ($services as $serviceData) {
                $payload = [
                    'sla_days' => $serviceData['sla_days'],
                    'description' => $serviceData['description'],
                    'is_active' => true,
                ];

                if ($hasDepartmentIdColumn) {
                    $payload['department_id'] = $department->id;
                }

                Service::query()->updateOrCreate(
                    [
                        'dept_id' => $department->id,
                        'service_name' => $serviceData['service_name'],
                    ],
                    $payload
                );
            }
        }
    }
}
