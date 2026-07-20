<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contacts = Contact::with('company')->get();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // TODO: add view return here
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()->route('contacts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): View
    {
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()->route('contacts.show', $contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index');
    }
}
