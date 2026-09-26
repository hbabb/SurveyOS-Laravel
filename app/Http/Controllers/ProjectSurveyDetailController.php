<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectSurveyDetailRequest;
use App\Http\Requests\UpdateProjectSurveyDetailRequest;
use App\Models\ProjectSurveyDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectSurveyDetailController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProjectSurveyDetail::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projectSurveyDetails = ProjectSurveyDetail::with([
            'project',
            'certifyingSurveyor',
            'drafter',
            'checker',
        ])->get();

        return view('project-survey-details.index', compact('projectSurveyDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('project-survey-details.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectSurveyDetailRequest $request): RedirectResponse
    {
        ProjectSurveyDetail::create($request->validated());

        return redirect()->route('project-survey-details.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectSurveyDetail $projectSurveyDetail): View
    {
        return view('project-survey-details.show', compact('projectSurveyDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectSurveyDetail $projectSurveyDetail): View
    {
        return view('project-survey-details.edit', compact('projectSurveyDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProjectSurveyDetailRequest $request,
        ProjectSurveyDetail $projectSurveyDetail,
    ): RedirectResponse {
        $projectSurveyDetail->update($request->validated());

        return redirect()->route('project-survey-details.show', $projectSurveyDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectSurveyDetail $projectSurveyDetail): RedirectResponse
    {
        $projectSurveyDetail->delete();

        return redirect()->route('project-survey-details.index');
    }
}
