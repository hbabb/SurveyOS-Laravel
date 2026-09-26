<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectCadSetupRequest;
use App\Http\Requests\UpdateProjectCadSetupRequest;
use App\Models\ProjectCadSetup;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectCadSetupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectCadSetup::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectCadSetups = ProjectCadSetup::with('project')->get();

        return view('project-cad-setups.index', compact('projectCadSetups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-cad-setups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectCadSetupRequest $request): RedirectResponse
    {
        ProjectCadSetup::create($request->validated());

        return redirect()->route('project-cad-setups.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectCadSetup $projectCadSetup): View
    {
        return view('project-cad-setups.show', compact('projectCadSetup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCadSetup $projectCadSetup): View
    {
        return view('project-cad-setups.edit', compact('projectCadSetup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProjectCadSetupRequest $request,
        ProjectCadSetup $projectCadSetup,
    ): RedirectResponse {
        $projectCadSetup->update($request->validated());

        return redirect()->route('project-cad-setups.show', $projectCadSetup);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCadSetup $projectCadSetup): RedirectResponse
    {
        $projectCadSetup->delete();

        return redirect()->route('project-cad-setups.index');
    }
}
