<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectParcelRequest extends FormRequest
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
            'sort_order' => 'required|integer',
            'parcel_label' => 'nullable|string|max:60',
            'subject_pin' => 'nullable|string|max:80',
            'current_owner_name' => 'nullable|string|max:220',
            'subdivision_name' => 'nullable|string|max:190',
            'lot_number' => 'nullable|string|max:40',
            'site_area_acres' => 'nullable|decimal:0,4|min:-999999.9999|max:999999.9999',
            'deed_book' => 'nullable|string|max:20',
            'deed_page' => 'nullable|string|max:20',
            'plat_book' => 'nullable|string|max:20',
            'plat_page' => 'nullable|string|max:20',
        ];
    }
}
