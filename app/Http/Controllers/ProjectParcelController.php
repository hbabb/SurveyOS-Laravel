<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectParcelRequest;
use App\Http\Requests\UpdateProjectParcelRequest;
use App\Models\ProjectParcel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectParcelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectParcel::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectParcels = ProjectParcel::with('project')->get();

        return view('project-parcels.index', compact('projectParcels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-parcels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectParcelRequest $request): RedirectResponse
    {
        ProjectParcel::create($request->validated());

        return redirect()->route('project-parcels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectParcel $projectParcel): View
    {
        return view('project-parcels.show', compact('projectParcel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectParcel $projectParcel): View
    {
        return view('project-parcels.edit', compact('projectParcel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectParcelRequest $request, ProjectParcel $projectParcel): RedirectResponse
    {
        $projectParcel->update($request->validated());

        return redirect()->route('project-parcels.show', $projectParcel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectParcel $projectParcel): RedirectResponse
    {
        $projectParcel->delete();

        return redirect()->route('project-parcels.index');
    }
}
