<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::paginate(6);
        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = new Type;
        return view('admin.types.form', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate_form($request);


        $type_data = $request->all();
        $type = new Type;

        $type->fill($type_data);
        $type->save();

        return redirect()->route("admin.types.index")
            ->with("message", "Type added successfully")
            ->with("type", "alert-success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
    //  * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        // Per avere la paginazione nella show dei type
        $related_projects = $type->projects()->paginate(5);
        return view('admin.types.show', compact('type', 'related_projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.form', compact('type'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
    //  * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {

        $this->validate_form($request, $type->id);

        $type_data = $request->all();
        $type->update($type_data);

        return redirect()->route('admin.types.index')
            ->with("message", "Type updated successfully")
            ->with("type", "alert-info");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        foreach ($type->projects as $project) {
            $project->delete();
        }

        $type->delete();
        return redirect()->route('admin.types.index')
            ->with("message", "Type deleted successfully")
            ->with("type", "alert-danger");
    }
    private function validate_form($request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'abstract' => 'required|string|max:100',
            'color' => 'required'
        ]);
    }
}
