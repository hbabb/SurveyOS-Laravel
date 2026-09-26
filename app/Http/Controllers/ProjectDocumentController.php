<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectDocumentRequest;
use App\Http\Requests\UpdateProjectDocumentRequest;
use App\Models\ProjectDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectDocumentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectDocument::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectDocuments = ProjectDocument::with(['project', 'uploadedByEmployee'])->get();

        return view('project-documents.index', compact('projectDocuments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectDocumentRequest $request): RedirectResponse
    {
        ProjectDocument::create($request->validated());

        return redirect()->route('project-documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectDocument $projectDocument): View
    {
        return view('project-documents.show', compact('projectDocument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectDocument $projectDocument): View
    {
        return view('project-documents.edit', compact('projectDocument'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectDocumentRequest $request, ProjectDocument $projectDocument): RedirectResponse
    {
        $projectDocument->update($request->validated());

        return redirect()->route('project-documents.show', $projectDocument);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectDocument $projectDocument): RedirectResponse
    {
        $projectDocument->delete();

        return redirect()->route('project-documents.index');
    }
}
