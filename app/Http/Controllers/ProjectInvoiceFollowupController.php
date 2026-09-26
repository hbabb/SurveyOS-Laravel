<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectInvoiceFollowupRequest;
use App\Http\Requests\UpdateProjectInvoiceFollowupRequest;
use App\Models\ProjectInvoiceFollowup;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectInvoiceFollowupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectInvoiceFollowup::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectInvoiceFollowups = ProjectInvoiceFollowup::with(['project', 'employee'])->get();

        return view('project-invoice-followups.index', compact('projectInvoiceFollowups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-invoice-followups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectInvoiceFollowupRequest $request): RedirectResponse
    {
        ProjectInvoiceFollowup::create($request->validated());

        return redirect()->route('project-invoice-followups.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectInvoiceFollowup $projectInvoiceFollowup): View
    {
        return view('project-invoice-followups.show', compact('projectInvoiceFollowup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectInvoiceFollowup $projectInvoiceFollowup): View
    {
        return view('project-invoice-followups.edit', compact('projectInvoiceFollowup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProjectInvoiceFollowupRequest $request,
        ProjectInvoiceFollowup $projectInvoiceFollowup,
    ): RedirectResponse {
        $projectInvoiceFollowup->update($request->validated());

        return redirect()->route('project-invoice-followups.show', $projectInvoiceFollowup);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectInvoiceFollowup $projectInvoiceFollowup): RedirectResponse
    {
        $projectInvoiceFollowup->delete();

        return redirect()->route('project-invoice-followups.index');
    }
}
