<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Roles or find Roles
        $roles = Role::when(request()->q, function ($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->with('permissions')->latest()->paginate(10);

        return Inertia::render('Apps/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get All Permissions
        $permissions = Permission::all();

        return Inertia::render('Apps/Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        // Create Role
        $role = Role::create(['name' => $request->name]);

        // Assign Permissions to Role
        $role->givePermissionTo($request->permissions);

        // Return Redirect
        return redirect()->route('apps.roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get Role
        $role = Role::with('permissions')->findOrFail($id);

        // Get All Permissions
        $permissions = Permission::all();

        // Redirect
        return Inertia::render('Apps/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
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
        // Validate Request
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        // Update Role
        $role->update(['name' => $request->name]);

        // Sync Permissions
        $role->syncPermissions($request->permissions);

        // Return Redirect
        return redirect()->route('apps.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find Roles by id
        $role = Role::findOrFail($id);

        // Delete Role
        $role->delete();

        // Return redirect
        return redirect()->route('apps.roles.index');
    }
}
