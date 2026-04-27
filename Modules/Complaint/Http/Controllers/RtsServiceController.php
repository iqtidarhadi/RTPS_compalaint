<?php

namespace Modules\Complaint\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Complaint\Models\Backend\Department;
use Modules\Complaint\Models\Service;

class RtsServiceController extends Controller
{
    public function index()
    {
        // List all departments
        $departments = Department::where('status', 'active')->get();
        return view('complaint::rts_services.index', compact('departments'));
    }

    public function showDepartment($id)
    {
        $department = Department::findOrFail($id);
        $services = Service::where('dept_id', $department->id)
            ->where('is_active', true)
            ->get();
        return view('complaint::rts_services.department', compact('department', 'services'));
    }
}
