<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get All Field or Find Field
        $fields = Field::when(request()->q, function ($fields) {
            $fields = $fields->where('name', 'like', '%' . request()->q . '%');
        })->with('groups')->latest()->paginate(10);

        // Return Inertia Render
        return Inertia::render('Apps/Fields/Index', [
            'fields' => $fields,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all groups
        $groups = Group::all();

        // Return Redirect
        return Inertia::render('Apps/Fields/Create', [
            'groups' => $groups,
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
            'name' => 'required|unique:fields,name',
            'budget' => 'required|numeric',
        ]);

        // Create Field
        Field::create([
            'name' => $request->name,
            'budget' => $request->budget,
        ]);

        // Return redirect
        return redirect()->route('apps.fields.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find Field by id
        $field = Field::findOrFail($id);

        return Inertia::render('Apps/Fields/Edit', [
            'field' => $field,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        // Validate Request
        $this->validate($request, [
            'name' => 'required|unique:fields,name,' . $field->id,
            'budget' => 'required|numeric',
        ]);

        // Update Field
        $field->update([
            'name' => $request->name,
            'budget' => $request->budget,
        ]);

        // Return redirect
        return redirect()->route('apps.fields.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find Field by id
        $field = Field::findOrFail($id);

        // Delete Field
        $field->delete();

        // Return Redirect
        return redirect()->route('apps.fields.index');
    }
}
