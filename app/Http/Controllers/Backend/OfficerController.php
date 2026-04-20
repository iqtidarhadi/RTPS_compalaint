<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\Backend\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class OfficerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:officer-list|officer-create|officer-edit|officer-delete', only: ['index', 'store']),
            new Middleware('permission:officer-create', only: ['create', 'store']),
            new Middleware('permission:officer-edit', only: ['edit', 'update']),
            new Middleware('permission:officer-delete', only: ['destroy']),
        ];
    }


    /**
     * Officer listing
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $modelData = Officer::with('department')->orderBy('id', 'desc');

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
                    return customButtonCrypt($row, 'officer', 'app.officers', false);
                })

                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return view('app.officers.index', [
            'title' => 'Officers Listings'
        ]);
    }


    /**
     * Create officer form
     */
    public function create()
    {
        $departments = Department::where('status', 'active')->pluck('name', 'id');

        return view('app.officers.create', [
            'title' => 'Create Officer',
            'isEdit' => false,
            'model' => null,
            'departments' => $departments
        ]);
    }


    /**
     * Store officer
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'dept_id' => ['required', 'exists:departments,id'],
                'name' => ['required', 'string', 'max:255'],
                'designation' => ['nullable', 'string', 'max:255'],
                'email' => ['nullable', 'email'],
                'phone' => ['nullable', 'string', 'max:20'],
                'is_active' => ['required', 'boolean'],
            ]);

            Officer::create($validatedData);

            return redirect()
                ->route('app.officers.index')
                ->with('success', 'Officer created successfully!');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error creating officer: ' . $e->getMessage());
        }
    }


    /**
     * Edit officer form
     */
    public function edit(string $id)
    {
        try {

            $officer = Officer::findOrFail(decrypt($id));

            $departments = Department::where('status', 'active')->pluck('name', 'id');

            return view('app.officers.edit', [
                'title' => 'Edit Officer',
                'isEdit' => true,
                'model' => $officer,
                'departments' => $departments
            ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('app.officers.index')
                ->with('error', 'Officer not found.');
        }
    }


    /**
     * Update officer
     */
    public function update(Request $request, string $id)
    {
        try {

            $officer = Officer::findOrFail(decrypt($id));

            $validatedData = $request->validate([
                'dept_id' => ['required', 'exists:departments,id'],
                'name' => ['required', 'string', 'max:255'],
                'designation' => ['nullable', 'string', 'max:255'],
                'email' => ['nullable', 'email'],
                'phone' => ['nullable', 'string', 'max:20'],
                'is_active' => ['required', 'boolean'],
            ]);

            $officer->update($validatedData);

            return redirect()
                ->route('app.officers.index')
                ->with('success', 'Officer updated successfully!');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error updating officer: ' . $e->getMessage());
        }
    }


    /**
     * Delete officer
     */
    public function destroy(string $id)
    {
        try {

            $officer = Officer::findOrFail(decrypt($id));

            $officer->delete();

            return redirect()
                ->route('app.officers.index')
                ->with('success', 'Officer deleted successfully!');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Error deleting officer: ' . $e->getMessage());
        }
    }
}