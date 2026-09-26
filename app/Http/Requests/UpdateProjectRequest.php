<?php

namespace App\Http\Requests;

use App\ProjectPriority;
use App\ProjectStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'project_no' => [
                'required',
                'string',
                'max:6',
                Rule::unique('projects', 'project_no')->ignore($this->route('project')),
            ],
            'project_name' => 'required|string|max:220',
            'proposal_id' => 'required|integer|exists:proposals,id',
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'status_changed_at' => 'nullable|date',
            'priority' => ['nullable', Rule::enum(ProjectPriority::class)],
            'field_scheduled_date' => 'nullable|date',
            'invoiced_at' => 'nullable|date',
            'last_followed_up_at' => 'nullable|date',
            'customer_status' => 'required|string|max:120',
            'target_delivery' => 'nullable|date',
            'project_manager_id' => 'nullable|integer|exists:employees,id',
            'researcher_id' => 'nullable|integer|exists:employees,id',
            'is_active' => 'required|boolean',
            'archived_at' => 'nullable|date',
        ];
    }
}
