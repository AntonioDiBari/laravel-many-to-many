<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTechnologyRequest;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::paginate(5);
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technology = new Technology;
        return view('admin.technologies.form', compact('technology'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        $request->validated();

        $technology_data = $request->all();
        $technology = new Technology;

        $technology->fill($technology_data);
        $technology->save();

        return redirect()->route("admin.technologies.index")
            ->with("message", "Technology added successfully")
            ->with("type", "alert-success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
    //  * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        // Per avere la paginazione nella show dei type
        $related_projects = $technology->projects()->orderBy('id', 'DESC')->paginate(5);
        return view('admin.technologies.show', compact('technology', 'related_projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.form', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
    //  * @return \Illuminate\Http\Response
     */
    public function update(StoreTechnologyRequest $request, Technology $technology)
    {
        $request->validated();

        $technology_data = $request->all();
        $technology->update($technology_data);

        return redirect()->route("admin.technologies.index")
            ->with("message", "Technology updated successfully")
            ->with("type", "alert-success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->projects()->detach();
        $technology->delete();
        return redirect()->route('admin.technologies.index')
            ->with("message", "Technology deleted successfully")
            ->with("type", "alert-danger");
    }
}
