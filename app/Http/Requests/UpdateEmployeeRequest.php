<?php

namespace App\Http\Requests;

use App\EmployeePosition;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('employees', 'user_id')->ignore($this->route('employee')),
            ],
            'position' => ['required', Rule::enum(EmployeePosition::class)],
            'initials' => 'required|string|max:3',
            'is_active' => 'required|boolean',
        ];
    }
}
