<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectInvoiceRequest;
use App\Http\Requests\UpdateProjectInvoiceRequest;
use App\Models\ProjectInvoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectInvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectInvoice::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectInvoices = ProjectInvoice::with('project')->get();

        return view('project-invoices.index', compact('projectInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectInvoiceRequest $request): RedirectResponse
    {
        ProjectInvoice::create($request->validated());

        return redirect()->route('project-invoices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectInvoice $projectInvoice): View
    {
        return view('project-invoices.show', compact('projectInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectInvoice $projectInvoice): View
    {
        return view('project-invoices.edit', compact('projectInvoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectInvoiceRequest $request, ProjectInvoice $projectInvoice): RedirectResponse
    {
        $projectInvoice->update($request->validated());

        return redirect()->route('project-invoices.show', $projectInvoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectInvoice $projectInvoice): RedirectResponse
    {
        $projectInvoice->delete();

        return redirect()->route('project-invoices.index');
    }
}
