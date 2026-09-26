<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectAdjoinerRequest extends FormRequest
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
            'owner_name' => 'nullable|string|max:220',
            'pin' => 'nullable|string|max:80',
            'deed_book' => 'nullable|string|max:20',
            'deed_page' => 'nullable|string|max:20',
            'plat_book' => 'nullable|string|max:20',
            'plat_page' => 'nullable|string|max:20',
            'subdivision_name' => 'nullable|string|max:190',
            'lot_number' => 'nullable|string|max:40',
            'zoning' => 'nullable|string|max:60',
        ];
    }
}
