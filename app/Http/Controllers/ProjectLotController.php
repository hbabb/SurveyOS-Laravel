<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectLotRequest;
use App\Http\Requests\UpdateProjectLotRequest;
use App\Models\ProjectLot;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectLotController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectLot::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectLots = ProjectLot::with(['project', 'deliverables'])->get();

        return view('project-lots.index', compact('projectLots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-lots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectLotRequest $request): RedirectResponse
    {
        ProjectLot::create($request->validated());

        return redirect()->route('project-lots.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectLot $projectLot): View
    {
        return view('project-lots.show', compact('projectLot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectLot $projectLot): View
    {
        return view('project-lots.edit', compact('projectLot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectLotRequest $request, ProjectLot $projectLot): RedirectResponse
    {
        $projectLot->update($request->validated());

        return redirect()->route('project-lots.show', $projectLot);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectLot $projectLot): RedirectResponse
    {
        $projectLot->delete();

        return redirect()->route('project-lots.index');
    }
}
