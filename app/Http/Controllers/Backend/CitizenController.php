<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Backend\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class CitizenController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:service-list|service-create|service-edit|service-delete', only: ['index', 'store']),
            new Middleware('permission:service-create', only: ['create', 'store']),
            new Middleware('permission:service-edit', only: ['edit', 'update']),
            new Middleware('permission:service-delete', only: ['destroy']),
        ];
    }

    /**
     * Display listing
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $modelData = Service::with('department')->orderBy('id', 'desc');

            return Datatables::of($modelData)
                ->addIndexColumn()

                ->addColumn('department', function ($row) {
                    return $row->department?->name ?? '-';
                })

                ->addColumn('status', function ($row) {
                    return $row->is_active
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return customButtonCrypt($row, 'service', 'app.services', false);
                })

                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return view('app.services.index', [
            'title' => 'Services Listings'
        ]);
    }


    /**
     * Create form
     */
    public function create()
    {
        $departments = Department::where('status', 'active')->pluck('name', 'id');

        return view('app.services.form', [
            'title' => 'Create Service',
            'isEdit' => false,
            'model' => null,
            'departments' => $departments
        ]);
    }


    /**
     * Store service
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'dept_id' => ['required', 'exists:departments,id'],
                'service_name' => ['required', 'string', 'max:255'],
                'sla_days' => ['nullable', 'integer'],
                'description' => ['nullable', 'string'],
                'is_active' => ['required', 'boolean'],
            ]);

            Service::create($validatedData);

            return redirect()
                ->route('app.services.index')
                ->with('success', 'Service created successfully!');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error creating service: ' . $e->getMessage());
        }
    }


    /**
     * Edit form
     */
    public function edit(string $id)
    {
        try {

            $service = Service::findOrFail(decrypt($id));

            $departments = Department::where('status', 'active')->pluck('name', 'id');

            return view('app.services.edit', [
                'title' => 'Edit Service',
                'isEdit' => true,
                'model' => $service,
                'departments' => $departments
            ]);

        } catch (\Exception $e) {

            return redirect()
                ->route('app.services.index')
                ->with('error', 'Service not found.');
        }
    }


    /**
     * Update service
     */
    public function update(Request $request, string $id)
    {
        try {

            $service = Service::findOrFail(decrypt($id));

            $validatedData = $request->validate([
                'dept_id' => ['required', 'exists:departments,id'],
                'service_name' => ['required', 'string', 'max:255'],
                'sla_days' => ['nullable', 'integer'],
                'description' => ['nullable', 'string'],
                'is_active' => ['required', 'boolean'],
            ]);

            $service->update($validatedData);

            return redirect()
                ->route('app.services.index')
                ->with('success', 'Service updated successfully!');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error updating service: ' . $e->getMessage());
        }
    }


    /**
     * Delete service
     */
    public function destroy(string $id)
    {
        try {

            $service = Service::findOrFail(decrypt($id));

            $service->delete();

            return redirect()
                ->route('app.services.index')
                ->with('success', 'Service deleted successfully!');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Error deleting service: ' . $e->getMessage());
        }
    }
}