<?php

namespace App\Http\Requests;

use App\ProposalAcceptanceSource;
use App\ProposalStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProposalRequest extends FormRequest
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
            'proposal_no' => [
                'required',
                'string',
                'max:8',
                Rule::unique('proposals', 'proposal_no')->ignore($this->route('proposal')),
            ],
            'site_intake_id' => 'required|integer|exists:site_intakes,id',
            'service_type' => 'nullable|string|max:140',
            'scope_description' => 'nullable|string',
            'exclusions_description' => 'nullable|string',
            'fee_amount' => 'nullable|decimal:0,2|min:-99999999.99|max:99999999.99',
            'status' => ['required', Rule::enum(ProposalStatus::class)],
            'sent_at' => 'nullable|date',
            'viewed_at' => 'nullable|date',
            'accepted_at' => 'nullable|date',
            'accepted_via' => ['nullable', Rule::enum(ProposalAcceptanceSource::class)],
            'accepted_by_employee_id' => 'nullable|integer|exists:employees,id',
            'accepted_note' => 'nullable|string',
            'accepted_ip_address' => 'nullable|string|max:45',
            'declined_at' => 'nullable|date',
            'declined_reason' => 'nullable|string',
        ];
    }
}
