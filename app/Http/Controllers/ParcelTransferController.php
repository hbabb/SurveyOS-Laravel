<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParcelTransferRequest;
use App\Http\Requests\UpdateParcelTransferRequest;
use App\Models\ParcelTransfer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParcelTransferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ParcelTransfer::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $parcelTransfers = ParcelTransfer::with(['projectParcel', 'projectDocument'])->get();

        return view('parcel-transfers.index', compact('parcelTransfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('parcel-transfers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParcelTransferRequest $request): RedirectResponse
    {
        ParcelTransfer::create($request->validated());

        return redirect()->route('parcel-transfers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParcelTransfer $parcelTransfer): View
    {
        return view('parcel-transfers.show', compact('parcelTransfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParcelTransfer $parcelTransfer): View
    {
        return view('parcel-transfers.edit', compact('parcelTransfer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParcelTransferRequest $request, ParcelTransfer $parcelTransfer): RedirectResponse
    {
        $parcelTransfer->update($request->validated());

        return redirect()->route('parcel-transfers.show', $parcelTransfer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParcelTransfer $parcelTransfer): RedirectResponse
    {
        $parcelTransfer->delete();

        return redirect()->route('parcel-transfers.index');
    }
}
