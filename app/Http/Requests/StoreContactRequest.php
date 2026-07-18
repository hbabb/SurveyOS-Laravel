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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address_line_1' => 'required_if:company_id,null',
            'city' => 'required_if:company_id,null',
            'state' => 'required_if:company_id,null',
            'zip' => 'required_if:company_id,null',
            'account_status' => 'required_if:company_id,null',
        ];
    }
}
