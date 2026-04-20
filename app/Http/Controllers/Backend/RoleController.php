<?php

namespace App\Http\Controllers\Backend;




use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\Menu;
use App\Models\Backend\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:role-list|role-create|role-edit|role-delete', only: ['index', 'store']),
            new Middleware('permission:role-create', only: ['create', 'store']),
            new Middleware('permission:role-edit', only: ['edit', 'update']),
            new Middleware('permission:role-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
{


    if ($request->ajax()) {
        $modelData = Role::query();
        $modelData->orderBy('id', 'desc');

        // Fix: Apply condition for non-Super Admin users
        if (!Auth::user()->hasRole('Super Admin')) {
            $modelData->where('is_generic', 0);
        }

        return Datatables::of($modelData)->addColumn('action', function ($row) {
            // Fix: Return something for generic roles too
            if ($row->is_generic == 1) {
                return '<span class="badge bg-secondary">System Role</span>';
            }
            return customButtonCrypt($row, 'role', 'app.roles', false);
        })->rawColumns(['action'])->toJson();
    }
    
    $data = [
        'title' => 'Role Listings',
    ];
    return view('app.role.index', $data);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'title' => 'Create Role',
            'back_route' => ['app.roles.index', 'Role Listings'],
            'menus' => Menu::get(),
            'permissions' => Permission::where('menu_id', 0)->get()
        ];
        return view('app.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'name' => 'required|string|unique:roles,name',
                'permission' => 'nullable|array',
            ]);

            // Create role
            $role = Role::create([
                'name' => $validatedData['name'],
                // 'guard_name' => $validatedData['guard_name'],
                // 'is_generic' => $validatedData['is_generic'],
            ]);

            // Sync permissions if provided
            if (!empty($validatedData['permission'])) {
                $permissions = Permission::whereIn('id', $validatedData['permission'])->pluck('name')->toArray();
                $role->syncPermissions($permissions);
            }
            // Success message
            Session::flash('success', 'Role created successfully');

            return redirect()->route('app.roles.index');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findorfail(Crypt::decrypt($id));
        $permissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('content.apps.role.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // Decrypt the role ID
        $roleId = Crypt::decrypt($id);

        // Find the role or throw a 404 error
        $role = Role::findOrFail($roleId);

        // Get all menus and permissions
        $menus = Menu::all();
        $permission = Permission::all();

        // Fetch other permissions (where menu_id = 0)
        $permissions = Permission::where('menu_id', 0)->get();

        // Fetch assigned role permissions
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_id", $roleId)
            ->pluck('permission_id')
            ->toArray(); // Use an array for easier use in views

        // Data for the view
        $data = [
            'title' => 'Edit Role',
            'back_route' => ['app.roles.index', 'Role Listings'],
            'new_route' => ['app.roles.edit', 'Edit Role'],
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermissions,
            'menus' => $menus,
            'permissions' => $permissions
        ];

        return view('app.role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Decrypt the role ID
            $roleId = Crypt::decrypt($id);

            // Find the role
            $role = Role::findOrFail($roleId);

            // Validate request
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
                'permission' => 'nullable|array',
                'permission.*' => 'exists:permissions,id' // Ensure all selected permissions exist
            ]);

            // Update role name
            $role->update(['name' => $request->input('name')]);

            // Retrieve permission names instead of IDs
            $permissions = Permission::whereIn('id', $request->input('permission', []))->pluck('name')->toArray();

            // Sync permissions properly
            $role->syncPermissions($permissions);

            return redirect()->route('app.roles.index')->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Decrypt role ID
            $roleId = Crypt::decrypt($id);

            // Find the role or fail
            $role = Role::findOrFail($roleId);

            // Detach all permissions
            $role->permissions()->detach();

            // Remove role from all users
            DB::table('model_has_roles')->where('role_id', $roleId)->delete();

            // Delete the role
            $role->delete();

            // Handle AJAX request
            if (request()->ajax()) {
                return response()->json(['success' => 'Role deleted successfully.']);
            }

            // Flash success message
            Session::flash('success', 'Role deleted successfully');
            return redirect()->route('app.roles.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }
}
