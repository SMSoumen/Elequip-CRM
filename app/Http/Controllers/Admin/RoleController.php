<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
// use Illuminate\Support\Facades\Schema;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller implements HasMiddleware
{    

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Role access|Role create|Role edit|Role delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Role create', only: ['create', 'store']),
            new Middleware('role_or_permission:Role edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Role delete', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $columns = Schema::getColumnListing('roles'); // users table
        // dd($columns);

        // $role = Role::with('permissions')->latest()->get();
        $auth_user = auth()->user();
        if ($auth_user->id !== 1) {
            $role = Role::with('permissions')->where('name', '!=', 'Super-Admin')->latest()->get();
        } else {
            $role = Role::with('permissions')->latest()->get();
        }
        return view('admin.setting.role.index', ['roles' => $role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('admin.setting.role.add', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'admin']);
        $permissions = array_map('intval', $request->permissions);
        $role->syncPermissions($permissions);

        return redirect()->back()->withSuccess('Role created !!!');
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
    public function edit(Role $role)
    {
        $permission = Permission::get();
        $role->permissions;
        return view('admin.setting.role.edit', ['role' => $role, 'permissions' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name, 'guard_name' => 'admin']);

        $permissions = array_map('intval', $request->permissions);
        $role->syncPermissions($permissions);
        return redirect()->back()->withSuccess('Role updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->withSuccess('Role deleted !!!');
    }
}
