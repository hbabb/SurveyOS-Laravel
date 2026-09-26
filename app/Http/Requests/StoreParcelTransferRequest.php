<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreParcelTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_parcel_id' => 'required|integer|exists:project_parcels,id',
            'grantor' => 'required|string|max:220',
            'grantee' => 'required|string|max:220',
            'deed_book' => 'required|string|max:20',
            'deed_page' => 'required|string|max:20',
            'plat_book' => 'nullable|string|max:20',
            'plat_page' => 'nullable|string|max:20',
            'recorded_date' => 'required|date',
            'instrument_type' => 'nullable|string|max:60',
            'project_document_id' => 'nullable|integer|exists:project_documents,id',
            'notes' => 'nullable|string',
        ];
    }
}
