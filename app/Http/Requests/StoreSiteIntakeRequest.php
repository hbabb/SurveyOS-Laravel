<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSiteIntakeRequest extends FormRequest
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
            'contact_id' => 'required|integer|exists:contacts,id',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:120',
            'county' => 'required|string|max:120',
            'state' => 'required|string|size:2',
            'zip' => 'nullable|string|max:10',
            'township' => 'nullable|string|max:120',
            'pin' => 'required_without:address_line_1|nullable|string|max:60',
            'notes' => 'nullable|string',
        ];
    }
}
