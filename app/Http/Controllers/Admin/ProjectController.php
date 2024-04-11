<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Mail\NewProjectMail;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'DESC')->paginate(4);
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
        $technologies = Technology::all();
        $project = new Project;
        return view('admin.projects.form', compact('project', 'types', 'technologies'));
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

        /* gestisto l'immagine e recupero il path se
        la mando, altrimenti image è nullable e sarà NULL*/
        if (isset($project_data['image'])) {
            $img_path = Storage::put('uploads/projects', $project_data['image']);
            $project->image = $img_path;
        }

        $project->save();

        /* Dopo il save perchè al momento il nuovo Project non ha ID prima del save,
        controllo però se c'è altrimenti posso mandare un nuovo Project senza Tech relazionate */
        if (array_key_exists('technologies', $project_data)) {
            $project->technologies()->attach($project_data['technologies']);
        }

        /* invio mail */
        Mail::to(strtolower(Auth::user()->name) . '@gmail.com')->send(new NewProjectMail($project, Auth::user()->name));

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
        $technologies = Technology::all();

        /* Recupera gli ID delle tecnologie associate al project, lasciando non serve il ?? []
        perchè nella store non c'è. (Ho lasciato la funzione direttamente nel ternario V/F 'checked')  */
        $technologies_id = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.form', compact('project', 'types', 'technologies', /* technologies_id */));
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

        // dd($project_data);
        /*  */
        if (isset($project_data['image'])) {
            if (isset($project->image)) {
                Storage::delete($project->image);
            }
            $img_path = Storage::put('uploads/projects', $project_data['image']);
            $project->image = $img_path;
        }

        $project->update($project_data);

        /* Stessa della store, controllo se vuole eliminare le relazioni
        perchè possbile possa deselezionare (eliminando con il detach senza param) */
        if (array_key_exists('technologies', $project_data)) {
            $project->technologies()->sync($project_data['technologies']);
        } else {
            $project->technologies()->detach();
        }

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
        /* Buona pratica dissociare ed eliminare le relazioni nella Pivot, prima di eliminare */
        $project->technologies()->detach();
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
            'type_id' => 'required|exists:types,id',
            'technologies' => 'exists:technologies,id',
            'image' => 'nullable|image'
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
