<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DepartmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:department-list|department-create|department-edit|department-delete', only: ['index', 'store']),
            new Middleware('permission:department-create', only: ['create', 'store']),
            new Middleware('permission:department-edit', only: ['edit', 'update']),
            new Middleware('permission:department-delete', only: ['destroy']),
        ];
    }

    /**
     * Display listing
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $modelData = Department::orderBy('id', 'desc');

            return Datatables::of($modelData)
                ->addIndexColumn()

                ->addColumn(
                    'status',
                    fn($row) => $row->status == 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>'
                )
                ->addColumn('action', fn($row) => customButtonCrypt($row, 'department', 'app.departments', false))

                ->rawColumns(['action', 'status'])
                ->toJson();
        }

        return view('app.departments.index', [
            'title' => 'Departments Listings'
        ]);
    }


    /**
     * Create form
     */
    public function create()
    {
        return view('app.departments.create', [
            'title' => 'Create Department',
            'isEdit' => false,
            'model' => null,
        ]);
    }


    /**
     * Store department
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:125'],
                'status' => ['required', 'string'],
            ]);

            Department::create($validatedData);

            return redirect()
                ->route('app.departments.index')
                ->with('success', 'Department created successfully!');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error creating department: ' . $e->getMessage());
        }
    }


    /**
     * Edit form
     */
    public function edit(string $id)
    {
        try {
  
            $department = Department::findOrFail(decrypt($id));
   
            return view('app.departments.edit', [
                'title' => 'Edit Department',
                'isEdit' => true,
                'model' => $department,
            ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('app.departments.index')
                ->with('error', 'Department not found.');
        }
    }


    /**
     * Update department
     */
    public function update(Request $request, string $id)
    {
        try {

            $department = Department::findOrFail(decrypt($id));

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:125'],
                'status' => ['required', 'string'],
            ]);

            $department->update($validatedData);

            return redirect()
                ->route('app.departments.index')
                ->with('success', 'Department updated successfully!');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error updating department: ' . $e->getMessage());
        }
    }


    /**
     * Delete department
     */
    public function destroy(string $id)
    {
        try {

            $department = Department::findOrFail(decrypt($id));

            $department->delete();

            return redirect()
                ->route('app.departments.index')
                ->with('success', 'Department deleted successfully!');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Error deleting department: ' . $e->getMessage());
        }
    }
}
