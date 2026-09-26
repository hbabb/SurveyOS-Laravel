<?php

namespace App\Http\Requests;

use App\DocumentType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectDocumentRequest extends FormRequest
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
            'type' => ['required', Rule::enum(DocumentType::class)],
            'path' => 'required|string|max:500',
            'original_filename' => 'required|string|max:255',
            'mime_type' => 'nullable|string|max:120',
            'size_bytes' => 'nullable|integer',
            'uploaded_by_employee_id' => 'nullable|integer|exists:employees,id',
        ];
    }
}
