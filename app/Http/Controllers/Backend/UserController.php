<?php


namespace App\Http\Controllers\Backend;



use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\District;
use App\Models\Backend\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class UserController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('permission:user-list|user-create|user-edit|user-delete', only: ['index', 'store']),
            new Middleware('permission:user-create', only: ['create', 'store']),
            new Middleware('permission:user-edit', only: ['edit', 'update']),
            new Middleware('permission:user-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
{
    if ($request->ajax() && $request->isMethod('post')) {
        $modelData = User::query();
        
        // Add a select statement to combine firstname and lastname
        $modelData->select('*', \DB::raw("CONCAT(firstname, ' ', lastname) as full_name"));
        
        $modelData->orderBy('id', 'desc');
        
        return Datatables::of($modelData)
            ->addColumn('name', function ($row) {
                return $row->firstname . ' ' . $row->lastname;
            })
            ->addColumn('action', function ($row) {
                return customButtonCrypt($row, 'user', 'app.users', false);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    $data = [
        'title' => 'Users Listings',
    ];
    return view('app.user.index', $data);
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        if (!Auth::user()->hasRole('Super Admin')) {
            $roles = Arr::except($roles, ['Super Admin']);
        }
        $data = [
            'title' => 'Create User',
            'back_route' => ['app.users.index', 'Users Listings'],
            'roles' => Role::pluck('name', 'name')->all(),
            'districts' => District::pluck('title', 'id')->all(),

        ];
        return view('app.user.create', $data);
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
            // Validate the request
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8', 'confirmed'], // "confirmed" checks for confirm_password
                'roles' => ['required', 'array'],
                'district_id' => ['required', 'integer'],
                'tehsil_id' => ['required', 'integer'],
            ]);

            // Prepare user data
            $validatedData['email_verified_at'] = now();
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Create the user
            $user = User::create($validatedData);

            // Assign roles
            $user->assignRole($request->input('roles'));

            // Flash success message
            Session::flash('success', 'User created successfully');

            return redirect()->route('app.users.index');
        } catch (\Exception $e) {
            // Flash error message
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput(); // Redirect back with old input
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
        $user = User::find(Crypt::decrypt($id));
        return view('content.apps.user.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::findorfail(Crypt::decrypt($id));

        $roles = Role::pluck('name', 'name')->all();
        if (!Auth::user()->hasRole('Super Admin')) {
            $roles = Arr::except($roles, ['Super Admin']);
        }
        $userRoles = $user->roles->pluck('name', 'name')->all();

        $data = [
            'title' => 'Update User',
            'back_route' => ['app.users.index', 'User Listings'],
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'districts' => District::pluck('title', 'id')->all(),
            'tehsils' => $user->district->tehsils->pluck('title', 'id')->all(),

        ];

        return view('app.user.edit', $data);
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
            // Decrypt the user ID
            $userId = Crypt::decrypt($id);
            $user = User::findOrFail($userId);

            // Validate the request
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'min:8', 'confirmed'], // Optional password change
                'roles' => ['required', 'array'],
                'district_id' => ['required', 'integer'],
                'tehsil_id' => ['required', 'integer'],
            ]);



            // Update user data
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->district_id = $validatedData['district_id'];
            $user->tehsil_id = $validatedData['tehsil_id'];

            // Only update password if provided
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save(); // Save user data
            // Convert role names to IDs
            $roleIds = Role::whereIn('name', $request->input('roles'))->pluck('id')->toArray();

            // Assign roles
            $user->roles()->sync($roleIds);

            // Flash success message
            Session::flash('success', 'User updated successfully');

            return redirect()->route('app.users.index');
        } catch (\Exception $e) {
            // Flash error message
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
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
        User::findorfail(Crypt::decrypt($id))->delete();
        if (request()->ajax()) {
            return response()->json(['success' => 'User deleted successfully.']);
        }

        Session::flash('success', 'User deleted successfully');
        return redirect()->route('app.users.index');
    }


    public function changePasswordFrom()
    {
        $data = [
            'title' => 'Change Password',
            'user' => User::where('id', \Auth::User()->id)->first()
        ];
        return view('app.user.change_password', $data);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);


        $user = User::find(\Auth::User()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            Session::flash('success', 'Password changed successfully');
        } else {
            Session::flash('error', 'Old password is incorrect');
        }
        return redirect()->back();
    }
}
