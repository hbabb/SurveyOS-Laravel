<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Proposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Proposal::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $proposals = Proposal::with(['siteIntake', 'acceptedByEmployee'])->get();

        return view('proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProposalRequest $request): RedirectResponse
    {
        Proposal::create($request->validated());

        return redirect()->route('proposals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal): View
    {
        return view('proposals.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal): View
    {
        return view('proposals.edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProposalRequest $request, Proposal $proposal): RedirectResponse
    {
        $proposal->update($request->validated());

        return redirect()->route('proposals.show', $proposal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal): RedirectResponse
    {
        $proposal->delete();

        return redirect()->route('proposals.index');
    }
}
