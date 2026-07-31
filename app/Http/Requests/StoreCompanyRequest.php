<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|string|max:220',
            'account_status' => 'required|in:active,inactive,prospect,suspended',
            'main_email' => 'nullable|email|max:190',
            'main_phone' => 'nullable|string|max:80',
            'accounting_email' => 'nullable|email|max:190',
            'billing_address_line_1' => 'required|string|max:255',
            'billing_address_line_2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:120',
            'billing_state' => 'required|string|size:2',
            'billing_zip' => 'required|string|max:10',
            'physical_address_line_1' => 'nullable|string|max:255',
            'physical_address_line_2' => 'nullable|string|max:255',
            'physical_city' => 'nullable|string|max:120',
            'physical_state' => 'nullable|string|size:2',
            'physical_zip' => 'nullable|string|max:10',
            'billing_notes' => 'nullable|string',
            'notes' => 'nullable|string',
            'restrict_contacts_to_assigned_projects' => 'boolean',
        ];
    }
}
