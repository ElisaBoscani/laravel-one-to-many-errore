<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projecs = Project::orderByDesc('id')->paginate(10);

        return view('admin.projecs.index', compact('projecs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projecs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->title, '-');

        if ($request->has('cover_image')) {

            $imagePath = 'posts_images/' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->storeAs('public/', $imagePath);
            $data['cover_image'] = $imagePath;
        }
        $data['url_view'] = $request->input('url_view');
        Project::create($data);
        return to_route('admin.projects.index')->with('message', 'creato');
    }




    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projecs.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projecs.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->title, '-');


        if ($request->has('cover_image')) {



            $imagePath = 'posts_images/' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->storeAs('public/', $imagePath);
            $data['cover_image'] = $imagePath;
        }

        $project->update($data);
        return to_route('admin.projects.index')->with('message', 'creato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (!is_null($project->posts_images)) {
            Storage::delete($project->posts_images);
        }
        $project->delete();
        return to_route('admin.projects.index')->with('message', 'creato');
    }
}
