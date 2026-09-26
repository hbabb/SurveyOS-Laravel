<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectInvoiceRequest extends FormRequest
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
            'project_id' => 'required|integer|exists:projects,id',
            'akaunting_invoice_no' => [
                'required',
                'string',
                'max:40',
                Rule::unique('project_invoices', 'akaunting_invoice_no')->ignore($this->route('project_invoice')),
            ],
            'amount' => 'required|decimal:0,2|min:-99999999.99|max:99999999.99',
            'paid_at' => 'nullable|date',
        ];
    }
}
