<?php

namespace App\Http\Requests;

use App\LocationSource;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectCadSetupRequest extends FormRequest
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
            'project_id' => [
                'required',
                'integer',
                'exists:projects,id',
                Rule::unique('project_cad_setups', 'project_id')
                    ->ignore($this->route('project_cad_setup')),
            ],
            'latitude' => 'nullable|decimal:0,7|min:-90|max:90',
            'longitude' => 'nullable|decimal:0,7|min:-180|max:180',
            'location_source' => ['nullable', Rule::enum(LocationSource::class)],
            'geocoded_at' => 'nullable|date',
        ];
    }
}
