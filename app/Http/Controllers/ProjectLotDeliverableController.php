<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectLotDeliverableRequest;
use App\Http\Requests\UpdateProjectLotDeliverableRequest;
use App\Models\ProjectLotDeliverable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectLotDeliverableController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectLotDeliverable::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectLotDeliverables = ProjectLotDeliverable::with('projectLot')->get();

        return view('project-lot-deliverables.index', compact('projectLotDeliverables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-lot-deliverables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectLotDeliverableRequest $request): RedirectResponse
    {
        ProjectLotDeliverable::create($request->validated());

        return redirect()->route('project-lot-deliverables.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectLotDeliverable $projectLotDeliverable): View
    {
        return view('project-lot-deliverables.show', compact('projectLotDeliverable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectLotDeliverable $projectLotDeliverable): View
    {
        return view('project-lot-deliverables.edit', compact('projectLotDeliverable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProjectLotDeliverableRequest $request,
        ProjectLotDeliverable $projectLotDeliverable,
    ): RedirectResponse {
        $projectLotDeliverable->update($request->validated());

        return redirect()->route('project-lot-deliverables.show', $projectLotDeliverable);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectLotDeliverable $projectLotDeliverable): RedirectResponse
    {
        $projectLotDeliverable->delete();

        return redirect()->route('project-lot-deliverables.index');
    }
}
