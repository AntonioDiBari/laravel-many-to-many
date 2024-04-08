<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(4);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $project = new Project;
        return view('admin.projects.form', compact('project', 'types'));
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
        $project_data = $request->all();
        $project = new Project;

        $project->fill($project_data);
        $project->save();

        return redirect()->route("admin.projects.index")
            ->with("message", "Project added successfully")
            ->with("type", "alert-success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
    //  * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.form', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
    //  * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->validate_form($request, $project->id);
        $project_data = $request->all();
        $project->update($project_data);

        return redirect()->route('admin.projects.index')
            ->with("message", "Project updated successfully")
            ->with("type", "alert-info");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')
            ->with("message", "Project deleted successfully")
            ->with("type", "alert-danger");
    }

    private function validate_form($request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'link_github' => 'required|url',
            'description' => 'nullable|min:3|max:1000',
            'type_id' => 'required|exists:types,id'
        ], [
            'name.required' => 'Il titolo è obbligatorio',
            'author.required' => "L'autore' è obbligatorio",
            'link_github.required' => 'Il link è obbligatorio',
            'link_github.url' => 'Il campo deve essere un link',
            'type_id.required' => 'Il campo seleziona è obbligatorio',
            'type_id.exists' => 'Il campo selezionato non è presente'
        ]);
    }
}
