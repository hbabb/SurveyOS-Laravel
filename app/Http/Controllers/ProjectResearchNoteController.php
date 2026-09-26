<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectResearchNoteRequest;
use App\Http\Requests\UpdateProjectResearchNoteRequest;
use App\Models\ProjectResearchNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectResearchNoteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectResearchNote::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectResearchNotes = ProjectResearchNote::with(['project', 'employee'])->get();

        return view('project-research-notes.index', compact('projectResearchNotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-research-notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectResearchNoteRequest $request): RedirectResponse
    {
        ProjectResearchNote::create($request->validated());

        return redirect()->route('project-research-notes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectResearchNote $projectResearchNote): View
    {
        return view('project-research-notes.show', compact('projectResearchNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectResearchNote $projectResearchNote): View
    {
        return view('project-research-notes.edit', compact('projectResearchNote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectResearchNoteRequest $request, ProjectResearchNote $projectResearchNote): RedirectResponse
    {
        $projectResearchNote->update($request->validated());

        return redirect()->route('project-research-notes.show', $projectResearchNote);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectResearchNote $projectResearchNote): RedirectResponse
    {
        $projectResearchNote->delete();

        return redirect()->route('project-research-notes.index');
    }
}
