<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Group or find it
        $groups = Group::when(request()->q, function ($groups) {
            $groups = $groups->where('name', 'like', '%' . request()->q . '%');
        })->with(['field', 'users'])->latest()->paginate(10);

        // Return Inertia
        return Inertia::render('Apps/Groups/Index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get All Fields
        $fields = Field::all();

        // Get All Users
        $users = User::all();

        // Return Inertia
        return Inertia::render('Apps/Groups/Create', [
            'fields' => $fields,
            'users' => $users,
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
            'field_id' => 'required',
            'name' => 'required|unique:groups,name',
            'spv' => 'required',
        ]);

        // Create Group
        Group::create([
            'field_id' => $request->field_id,
            'name' => $request->name,
            'spv' => $request->spv,
        ]);

        // Return Redirect
        return redirect()->route('apps.groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find Fields or Find
        $fields = Field::all();
        $group = Group::findOrFail($id);

        // Return Inertia
        return Inertia::render('Apps/Groups/Edit', [
            'fields' => $fields,
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        // Validate Request
        $this->validate($request, [
            'field_id' => 'required',
            'name' => 'required|unique:groups,name,' . $group->id,
            'spv' => 'required',
        ]);

        // Group Update
        $group->update([
            'field_id' => $request->field_id,
            'name' => $request->name,
            'spv' => $request->spv,
        ]);

        // Return Redirect
        return redirect()->route('apps.groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find Group by id
        $group = Group::findOrFail($id);

        // Delete Group
        $group->delete();

        // Return Redirect
        return redirect()->route('apps.groups.index');
    }
}
