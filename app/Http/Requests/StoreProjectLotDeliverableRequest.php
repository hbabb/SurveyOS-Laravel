<?php

namespace App\Http\Requests;

use App\LotDeliverableType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectLotDeliverableRequest extends FormRequest
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
            'project_lot_id' => 'required|integer|exists:project_lots,id',
            'type' => [
                'required',
                Rule::enum(LotDeliverableType::class),
                Rule::unique('project_lot_deliverables', 'type')
                    ->where('project_lot_id', $this->input('project_lot_id')),
            ],
            'date_ordered' => 'nullable|date',
            'date_completed' => 'nullable|date',
        ];
    }
}
