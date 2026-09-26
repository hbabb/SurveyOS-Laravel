<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectFemaReferenceRequest;
use App\Http\Requests\UpdateProjectFemaReferenceRequest;
use App\Models\ProjectFemaReference;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectFemaReferenceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectFemaReference::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectFemaReferences = ProjectFemaReference::with('project')->get();

        return view('project-fema-references.index', compact('projectFemaReferences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-fema-references.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectFemaReferenceRequest $request): RedirectResponse
    {
        ProjectFemaReference::create($request->validated());

        return redirect()->route('project-fema-references.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectFemaReference $projectFemaReference): View
    {
        return view('project-fema-references.show', compact('projectFemaReference'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectFemaReference $projectFemaReference): View
    {
        return view('project-fema-references.edit', compact('projectFemaReference'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProjectFemaReferenceRequest $request,
        ProjectFemaReference $projectFemaReference,
    ): RedirectResponse {
        $projectFemaReference->update($request->validated());

        return redirect()->route('project-fema-references.show', $projectFemaReference);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectFemaReference $projectFemaReference): RedirectResponse
    {
        $projectFemaReference->delete();

        return redirect()->route('project-fema-references.index');
    }
}
