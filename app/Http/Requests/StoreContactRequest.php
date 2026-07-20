<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $companyId = $this->input('company_id');

        return [
            'address_line_1' => $companyId === null ? 'required' : 'nullable',
            'city' => $companyId === null ? 'required' : 'nullable',
            'state' => $companyId === null ? 'required' : 'nullable',
            'zip' => $companyId === null ? 'required' : 'nullable',
            'account_status' => $companyId === null ? 'required' : 'nullable',
        ];
    }
}
