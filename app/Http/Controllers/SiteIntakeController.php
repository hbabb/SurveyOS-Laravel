<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteIntakeRequest;
use App\Http\Requests\UpdateSiteIntakeRequest;
use App\Models\SiteIntake;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteIntakeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SiteIntake::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $siteIntakes = SiteIntake::with('contact')->get();

        return view('site-intakes.index', compact('siteIntakes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('site-intakes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteIntakeRequest $request): RedirectResponse
    {
        SiteIntake::create($request->validated());

        return redirect()->route('site-intakes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteIntake $siteIntake): View
    {
        return view('site-intakes.show', compact('siteIntake'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteIntake $siteIntake): View
    {
        return view('site-intakes.edit', compact('siteIntake'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteIntakeRequest $request, SiteIntake $siteIntake): RedirectResponse
    {
        $siteIntake->update($request->validated());

        return redirect()->route('site-intakes.show', $siteIntake);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteIntake $siteIntake): RedirectResponse
    {
        $siteIntake->delete();

        return redirect()->route('site-intakes.index');
    }
}
