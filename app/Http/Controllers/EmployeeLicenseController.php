<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeLicenseRequest;
use App\Http\Requests\UpdateEmployeeLicenseRequest;
use App\Models\EmployeeLicense;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeLicenseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(EmployeeLicense::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $employeeLicenses = EmployeeLicense::with('employee')->get();

        return view('employee-licenses.index', compact('employeeLicenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('employee-licenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeLicenseRequest $request): RedirectResponse
    {
        EmployeeLicense::create($request->validated());

        return redirect()->route('employee-licenses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeLicense $employeeLicense): View
    {
        return view('employee-licenses.show', compact('employeeLicense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeLicense $employeeLicense): View
    {
        return view('employee-licenses.edit', compact('employeeLicense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEmployeeLicenseRequest $request,
        EmployeeLicense $employeeLicense,
    ): RedirectResponse {
        $employeeLicense->update($request->validated());

        return redirect()->route('employee-licenses.show', $employeeLicense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeLicense $employeeLicense): RedirectResponse
    {
        $employeeLicense->delete();

        return redirect()->route('employee-licenses.index');
    }
}
