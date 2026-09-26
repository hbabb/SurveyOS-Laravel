<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectSurveyDetailRequest extends FormRequest
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
                Rule::unique('project_survey_details', 'project_id')
                    ->ignore($this->route('project_survey_detail')),
            ],
            'drawing_title' => 'nullable|string|max:220',
            'ordered_by_name' => 'nullable|string|max:190',
            'zoning_district' => 'nullable|string|max:60',
            'setback_front_ft' => 'nullable|decimal:0,2|min:-9999.99|max:9999.99',
            'setback_side_ft' => 'nullable|decimal:0,2|min:-9999.99|max:9999.99',
            'setback_rear_ft' => 'nullable|decimal:0,2|min:-9999.99|max:9999.99',
            'setback_notes' => 'nullable|string',
            'ngs_monument_name' => 'nullable|string|max:80',
            'ngs_combined_scale_factor' => 'nullable|decimal:0,8|min:-99.99999999|max:99.99999999',
            'horizontal_datum' => 'nullable|string|max:60',
            'vertical_datum' => 'nullable|string|max:60',
            'basis_of_bearing' => 'nullable|string',
            'benchmark_description' => 'nullable|string|max:190',
            'certifying_surveyor_id' => [
                'nullable',
                'integer',
                Rule::exists('employees', 'id')->where('position', 'pls'),
            ],
            'field_date' => 'nullable|date',
            'survey_date' => 'nullable|date',
            'draft_date' => 'nullable|date',
            'checked_date' => 'nullable|date',
            'drafter_id' => 'nullable|integer|exists:employees,id',
            'checker_id' => 'nullable|integer|exists:employees,id',
            'revision' => 'nullable|string|max:20',
            'sheet_no' => 'nullable|integer',
            'total_sheets' => 'nullable|integer',
            'scale_text' => 'nullable|string|max:40',
            'field_draft_started' => 'required|boolean',
            'recording_requested' => 'nullable|boolean',
        ];
    }
}
