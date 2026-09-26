<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectAdjoinerRequest;
use App\Http\Requests\UpdateProjectAdjoinerRequest;
use App\Models\ProjectAdjoiner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectAdjoinerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectAdjoiner::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectAdjoiners = ProjectAdjoiner::with('projectParcel')->get();

        return view('project-adjoiners.index', compact('projectAdjoiners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-adjoiners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectAdjoinerRequest $request): RedirectResponse
    {
        ProjectAdjoiner::create($request->validated());

        return redirect()->route('project-adjoiners.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectAdjoiner $projectAdjoiner): View
    {
        return view('project-adjoiners.show', compact('projectAdjoiner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectAdjoiner $projectAdjoiner): View
    {
        return view('project-adjoiners.edit', compact('projectAdjoiner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectAdjoinerRequest $request, ProjectAdjoiner $projectAdjoiner): RedirectResponse
    {
        $projectAdjoiner->update($request->validated());

        return redirect()->route('project-adjoiners.show', $projectAdjoiner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectAdjoiner $projectAdjoiner): RedirectResponse
    {
        $projectAdjoiner->delete();

        return redirect()->route('project-adjoiners.index');
    }
}
