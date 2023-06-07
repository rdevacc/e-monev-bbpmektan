<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {

        // Get All Users
        $users = User::when(request()->q, function ($users) {
            $users = $users->where('name', 'like', '%' . request()->q . '%');
        })->with(['roles', 'group', 'field'])->latest()->paginate(10);

        return Inertia::render('Apps/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        // Get Datas
        $roles = DB::table('roles')->latest()->get();
        $fields = DB::table('fields')->orderBy('name')->get();
        $groups = DB::table('groups')->orderBy('name')->get();

        return Inertia::render('Apps/Users/Create', [
            'roles' => $roles,
            'fields' => $fields,
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        // Validate Request
        $this->validate($request, [
            'group_id' => 'required',
            'field_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'group_id' => $request->group_id,
            'field_id' => $request->field_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('apps.users.index');
    }

    public function edit($id)
    {
        // Get User
        $user = User::with('roles')->findOrFail($id);

        // Get Datas
        $roles = Role::all();
        $groups = Group::all();
        $fields = Field::all();

        return Inertia::render('Apps/Users/Edit', [
            'user' => $user,
            'roles' => $roles,
            'groups' => $groups,
            'fields' => $fields,
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Validate Request
        $this->validate($request, [
            'group_id' => 'required',
            'field_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed',
        ]);

        // Check Password Empty
        if ($request->password == '' || $request->password == null) {
            $user->update([
                'group_id' => $request->group_id,
                'field_id' => $request->field_id,
                'name' => $request->name,
                'email' => $request->email,
            ]);
        } else {
            $user->update([
                'group_id' => $request->group_id,
                'field_id' => $request->field_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        // Assign Role to User
        $user->syncRoles($request->roles);

        return redirect()->route('apps.users.index');
    }

    public function destroy($id)
    {

        // Find User
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('apps.users.index');
    }
}
