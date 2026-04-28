<?php

namespace Modules\Complaint\Http\Controllers;

use Illuminate\Routing\Controller;

class RtsServiceController extends Controller
{
    public function index()
    {
        $services = collect($this->dummyServices())->values();

        $summary = [
            'critically_delayed' => $services->sum('critical'),
            'delivered_services' => $services->sum('on_time'),
            'on_time_delivered' => $services->sum('on_time'),
            'total_pending' => $services->sum('delayed'),
        ];

        return view('complaint::rts_services.index', compact('services', 'summary'));
    }

    public function showDepartment($id)
    {
        $service = collect($this->dummyServices())->firstWhere('id', (int) $id);

        abort_unless($service, 404);

        return view('complaint::rts_services.department', compact('service'));
    }

    public function department_user($id)
    {
        $service = collect($this->dummyServices())->firstWhere('id', (int) $id);

        abort_unless($service, 404);

        return view('complaint::rts_services.department_user', compact('service'));
    }

    public function statistics()
    {
        return view('complaint::rts_services.statistics');
    }

    protected function dummyServices(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Arms License',
                'department' => 'Home',
                'timeline' => '37 Days',
                'avg_time' => '42 Days',
                'total_applications' => 54,
                'on_time' => 5,
                'delayed' => 25,
                'critical' => 24,
                'performance_label' => 'Below Satisfactory',
                'performance_class' => 'danger',
                'delayed_cases' => [
                    ['name' => 'Fazal Manan', 'address' => 'Malakand', 'cnic' => '12548-547245-6', 'date' => '12 Jan 2026', 'delayed_days' => 42, 'status' => 'Critically Delayed', 'status_class' => 'danger', 'action' => 'Show Cause'],
                    ['name' => 'Jawad Khan', 'address' => 'Peshawar', 'cnic' => '17301-8874123-4', 'date' => '16 Jan 2026', 'delayed_days' => 35, 'status' => 'Delayed', 'status_class' => 'warning', 'action' => 'Send Reminder'],
                    ['name' => 'Rafiullah', 'address' => 'Mardan', 'cnic' => '17301-1234567-8', 'date' => '20 Jan 2026', 'delayed_days' => 32, 'status' => 'Delayed', 'status_class' => 'warning', 'action' => 'Send Reminder'],
                ],
                'applicants' => [
                    ['name' => 'Mustafa Jan', 'address' => 'Peshawar', 'cnic' => '17301-4758125-8', 'date' => '12 Jan 2026', 'approved_by' => 'Shaukat Khan (DC Office)', 'status' => 'Delivered', 'status_class' => 'success', 'action' => 'View File'],
                    ['name' => 'Kashif Khan', 'address' => 'Nowshera', 'cnic' => '17301-8872145-1', 'date' => '14 Jan 2026', 'approved_by' => 'Shaukat Khan (DC Office)', 'status' => 'Dependency', 'status_class' => 'danger', 'action' => 'Review Dependency'],
                    ['name' => 'Ali Raza', 'address' => 'Charsadda', 'cnic' => '17301-4478123-7', 'date' => '18 Jan 2026', 'approved_by' => 'Shaukat Khan (DC Office)', 'status' => 'Payment', 'status_class' => 'warning', 'action' => 'Verify Payment'],
                ],
            ],
            [
                'id' => 2,
                'title' => 'Domicile',
                'department' => 'Home',
                'timeline' => '14 Days',
                'avg_time' => '12 Days',
                'total_applications' => 65,
                'on_time' => 30,
                'delayed' => 20,
                'critical' => 15,
                'performance_label' => 'Average',
                'performance_class' => 'warning',
                'delayed_cases' => [
                    ['name' => 'Sami Ullah', 'address' => 'Peshawar', 'cnic' => '17301-2548712-3', 'date' => '10 Jan 2026', 'delayed_days' => 19, 'status' => 'Delayed', 'status_class' => 'warning', 'action' => 'Send Reminder'],
                    ['name' => 'Noman', 'address' => 'Swabi', 'cnic' => '17301-3322144-1', 'date' => '13 Jan 2026', 'delayed_days' => 22, 'status' => 'Critically Delayed', 'status_class' => 'danger', 'action' => 'Show Cause'],
                ],
                'applicants' => [
                    ['name' => 'Bilal Ahmed', 'address' => 'Mardan', 'cnic' => '17301-4478211-9', 'date' => '11 Jan 2026', 'approved_by' => 'DCO Home Branch', 'status' => 'Delivered', 'status_class' => 'success', 'action' => 'View File'],
                    ['name' => 'Saad', 'address' => 'Peshawar', 'cnic' => '17301-9912455-2', 'date' => '13 Jan 2026', 'approved_by' => 'DCO Home Branch', 'status' => 'Pending', 'status_class' => 'warning', 'action' => 'Follow Up'],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Motor Vehicle Registration',
                'department' => 'Transport',
                'timeline' => '10 Days',
                'avg_time' => '8 Days',
                'total_applications' => 23,
                'on_time' => 14,
                'delayed' => 6,
                'critical' => 3,
                'performance_label' => 'Satisfactory',
                'performance_class' => 'success',
                'delayed_cases' => [
                    ['name' => 'Fahad', 'address' => 'Peshawar', 'cnic' => '17301-1122455-9', 'date' => '09 Jan 2026', 'delayed_days' => 12, 'status' => 'Delayed', 'status_class' => 'warning', 'action' => 'Send Reminder'],
                ],
                'applicants' => [
                    ['name' => 'Waqas', 'address' => 'Nowshera', 'cnic' => '17301-6678122-3', 'date' => '08 Jan 2026', 'approved_by' => 'MVR Officer', 'status' => 'Delivered', 'status_class' => 'success', 'action' => 'View File'],
                ],
            ],
            [
                'id' => 4,
                'title' => 'Driving License',
                'department' => 'Transport',
                'timeline' => '3 Days',
                'avg_time' => '2 Days',
                'total_applications' => 20,
                'on_time' => 12,
                'delayed' => 5,
                'critical' => 3,
                'performance_label' => 'Below Average',
                'performance_class' => 'warning',
                'delayed_cases' => [
                    ['name' => 'Haris', 'address' => 'Kohat', 'cnic' => '17301-7812455-5', 'date' => '07 Jan 2026', 'delayed_days' => 5, 'status' => 'Delayed', 'status_class' => 'warning', 'action' => 'Send Reminder'],
                ],
                'applicants' => [
                    ['name' => 'Usama', 'address' => 'Peshawar', 'cnic' => '17301-4412788-6', 'date' => '06 Jan 2026', 'approved_by' => 'License Office', 'status' => 'Delivered', 'status_class' => 'success', 'action' => 'View File'],
                ],
            ],
        ];
    }
}
