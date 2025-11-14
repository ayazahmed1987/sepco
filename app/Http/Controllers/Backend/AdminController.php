<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;
class AdminController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:admin-list', ['only' => ['index']]);
         $this->middleware('permission:admin-create', ['only' => ['create','store']]);
         $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }

    public function ShowLoginForm(){
        return view('backend.auth.login');
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::guard('admin')->user()->isactive == 1){
                return redirect()->route('manager.dashboard')->with('success', 'Admin Login Successfully');
            }else{
                Auth::guard('admin')->logout();
                return redirect()->route('manager.login')->with('error', 'Automatically Logout You Are Not Active User Please contact to Administrator');
            }
        }

        return redirect()->route('manager.login')->with('error', 'This credentials is incorrect');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('manager.login')->with('success','Admin has been logged out!');
    }

    public function index(Request $request): View
    {
        $user = Auth::guard('admin')->user();
        if ($user && $user->hasRole('Super Admin')) {
            $data = Admin::latest()->get();
        }else{
            $data = Admin::whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            })->get();
        }

        return view('backend.authentication.admins.index',compact('data'));
    }

    public function create(): View
    {
        $user = Auth::guard('admin')->user();
        $roles = Role::when(!$user->hasRole('Super Admin'), function ($query) {
            $query->where('name', '!=', 'Super Admin');
        })->orderBy('id','DESC')->pluck('name','name')->all();

        return view('backend.authentication.admins.create',compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = Admin::create($input);
        $user->assignRole($request->input('roles'));
		
		// Handle avatar upload (if provided)
		if ($request->hasFile('avatar')) {
			$user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
		}
		
        activity()->causedBy(auth()->user())->performedOn($input)->event('created')->log('Add new admin user');
        return redirect()->route('manager.users.index')->with('success','User created successfully');
    }

    public function show($id): View
    {
        $user = Admin::find($id);

        return view('users.show',compact('user'));
    }

    public function edit($id): View
    {
        try {
            $row_id = decrypt($id);
            $admin = Admin::findOrFail($row_id);
            $user = Auth::guard('admin')->user();
            $roles = Role::when(!$user->hasRole('Super Admin'), function ($query) {
                $query->where('name', '!=', 'Super Admin');
            })->orderBy('id','DESC')->pluck('name','name')->all();
            return view('backend.authentication.admins.edit',compact('admin','roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Failed to load edit page!');
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
			'user_code' => 'required|unique:admins,user_code,'.$id,
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'same:confirm-password',
			'roles' => 'required'
        ]);
        $input = $request->all();
		
		//dd($input);
		
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
		$admin = Admin::find($id);
        $admin->update($input);
		
		// Handle avatar upload (if provided)
		if ($request->hasFile('avatar')) {	
		// Remove the old file
		$admin->clearMediaCollection('avatar');

		// Add the new file
		//$admin->addMediaFromRequest('avatar')->toMediaCollection('avatar');
		$admin->addMedia($request->file('avatar'))->toMediaCollection('avatar');
		}
		
		activity()->causedBy(auth()->user())->performedOn($admin)->withProperties($input)->event('updated')->log('Update admin user');
		
        DB::table('model_has_roles')->where('model_type', 'App\Models\Admin')->where('model_id',$id)->delete();
		if(!empty($request->roles)){ $admin->assignRole($request->input('roles')); }
		return redirect()->route('manager.users.index')->with('success','Admin user updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $row_id = decrypt($id);
            $admin = Admin::findOrFail($row_id);
            $admin->delete();
			activity()->causedBy(auth()->user())->performedOn($admin)->event('deleted')->log('Delete admin user');
            return redirect()->route('manager.users.index')->with('success','Admin user deleted successfully');
        } catch (DecryptException $e) {
            return redirect()->back()->with('error','Failed to delete!');
        }
    }
}
