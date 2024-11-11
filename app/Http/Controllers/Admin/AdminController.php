<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Admin access|Admin create|Admin edit|Admin delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Admin create', only: ['create', 'store']),
            new Middleware('role_or_permission:Admin edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Admin delete', only: ['destroy']),

        ];
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth_user = auth('admin')->user();
        if ($auth_user->id !== 1) {
            $users = Admin::where('id', '!=', 1)->latest()->get();
        } else {
            $users = Admin::latest()->get();
        }
        return view('admin.setting.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = Role::get();
        return view('admin.setting.user.add', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:8|max:25'
        ]);
        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles);
        return redirect()->back()->withSuccess('Admin created !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $user)
    {
        $role = $role = Role::get();
        return view('admin.setting.user.edit', ['user' => $user, 'roles' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
        ]);

        if ($request->password != null) {
            $request->validate([
                'password' => 'required|confirmed'
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        // dd($request->all());
        $user->update($validated);

        $user->syncRoles($request->roles);
        return redirect()->back()->withSuccess('Admin updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $user)
    {
        $user->delete();
        return redirect()->back()->withSuccess('Admin deleted !!!');
    }

    public function userStatusChange(Request $request)
    {
        // dd($request->user_id);
        $user = Admin::where('id', $request->user_id)->first();
        $user_status = ($request->user_stat == 'true') ? 1 : 0;

        // dd($user_status);

        if ($user) {
            $user->where('id', $request->user_id)->update(['status' => $user_status]);
            return response()->json(['error' => false, 'msg' => 'Admin status updated']);
            // if ($response) {
            //     return response()->json(['error' => false, 'msg' => 'Admin status updated']);
            // } else {
            //     return response()->json(['error' => true, 'msg' => 'Admin not updated']);
            // }
        } else {
            return response()->json(['error' => true, 'msg' => 'Admin not found']);
        }
    }
}
